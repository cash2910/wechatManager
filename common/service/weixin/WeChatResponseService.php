<?php
namespace common\service\weixin;

use yii;
use yii\base\Module;
use yii\base\Exception;
use common\service\users\UserService;
use yii\base\Event;
use yii\db\ActiveRecord;
use common\models\MgUserRel;
use common\components\WeixinMenuConfig;
use yii\helpers\ArrayHelper;
use common\models\MgUsers;
/**
 * 回复微信消息方法
 * @author zaixing.jiang
 */
class WeChatResponseService extends Module{

    /**
     * 接收消息
     * @param unknown $params
     */
    public function run( $params ){
        $eventObj = $this->getEvent( $params );
        $event = new Event();
        $event->sender = $eventObj;
        $eventName = strtolower( $eventObj->MsgType );
        if( $eventObj->MsgType == 'event' )
            $eventName = strtolower( $eventObj->Event );
        $this->trigger( $eventName , $event );
        return $eventObj;
    }
    
    public function init(){
        //接收普通消息  text image ...
        $this->on('text', function( $event ){
            $entity = $event->sender;
            if( $entity->Content == '咨询客服' ){
                $hour = (int)date('h', $_SERVER['REQUEST_TIME']);
                if( $hour < 9 || $hour > 19  ){
                    $entity->setResp([
                        'FromUserName'=>$entity->ToUserName,
                        'ToUserName'=>$entity->FromUserName,
                        'MsgType'=>'text',
                        'Content'=>'您好，人工客服时间为9：00-19：00。目前时段，您可以先留言，我们会在下个人工服务时间第一时间回复您的问题。'
                    ]);
                    return ;
                }
                $entity->setResp([
                    'FromUserName'=>$entity->ToUserName,
                    'ToUserName'=>$entity->FromUserName,
                    'MsgType'=>'transfer_customer_service',
                    'TransInfo'=>[
                        'KfAccount'=>''
                    ]
                ]);
                $ret = WeChatService::getIns()->sendCsMsg([
                    'touser'=> $entity->FromUserName ,
                    'msgtype'=>'text',
                    'text'=>[
                        'content'=> "尊敬的用户，坐席正忙，请耐心等待，谢谢！",
                    ]
                ]);
                yii::error( "cs: ".$entity->FromUserName );
                return ;
            }
            
             $msg = <<<EOF
客官，终于等到您了，欢迎关注人人麻将公众号！

点击：下载游戏

点击：提交BUG奖励元宝

点击：充值元宝

点击：代理后台

点击：邀请好友组局（生成自己专属二维码，推广下线）


我们正在招兵买马，全国范围内招收代理：代理可享受以下政策

1、可查看好友账单明细与提现等操作。
      
2、生成自己专属二维码，方便推广。

3、成功绑定下级，享受名下玩家消费返利。

4、免费培训，帮助代理躺着赚钱。 
EOF;
             $entity->setResp([
                 'FromUserName'=>$entity->ToUserName,
                 'ToUserName'=>$entity->FromUserName,
                 'MsgType'=>'text',
                 'Content'=>$msg
             ]);
        });
        /**
         * 用户订阅 ...
         * 获取推广id, 创建用户 并绑定关系
         */
        $this->on('subscribe', function( $event ){
            $uServ = UserService::getInstance();
            $entity = $event->sender;
            $open_id =  $entity->FromUserName;
            //上级用户
            $supperObj = null;
            yii::error( "_key:".$entity->EventKey );
            if( !empty( $entity->EventKey ) ){
                list( $p, $id ) = explode("_",$entity->EventKey); //上级id
                yii::error( "key:".$entity->EventKey."id:".$id);
                $supperObj = $uServ->getUserInfo(['id'=> $id ]);
            }
            //判断用户是否存在
            if( ( $uObj = $uServ->getUserInfo(['open_id'=>$open_id]) ) == true  ){
                //savelog...
                $uObj->status = MgUsers::IS_SUBSCRIPT;
                $uObj->save();
                //建立绑定关系
                if( $supperObj ){
                    $ret = $uServ->bindRel( $supperObj,  $uObj );
                    yii::error( json_encode( $ret ) );
                    if( $ret['isOk'] ){
                        //通知上线用户
                        $ret = WeChatService::getIns()->sendCsMsg([
                            'touser'=> $supperObj->open_id ,
                            'msgtype'=>'text',
                            'text'=>[
                                'content'=> "{$uObj->nickname} 成功绑定为您的好友 ！",
                            ]
                        ]);
                        yii::error( '通知信息 :'.json_encode( $ret ) );
                    }
                }
            }else{
                //获取用户微信信息
                $uwInfo = WeChatService::getIns()->getUserInfo([
                    'openid'=> $open_id 
                ]);
                yii::error( "用户信息：".json_encode( $uwInfo ) );
                $ret = $uServ->createUser([
                    'open_id' =>  $open_id,
                    'union_id' =>  $uwInfo['unionid'],
                    'nickname'=> $uwInfo['nickname'],
                    'user_logo'=>$uwInfo['headimgurl'],
                ],function( $model ) use ( $supperObj ){
                    //若不存在招募关系 则不进行关系绑定
                    if(  !$supperObj )
                        return false;
                    try{
                        $ret = $uServ->bindRel( $supperObj,  $uObj );
                        if( $ret['isOk'] ){
                            //通知上线用户
                            $ret = WeChatService::getIns()->sendCsMsg([
                                'touser'=> $supperObj->open_id ,
                                'msgtype'=>'text',
                                'text'=>[
                                    'content'=> "{$uObj->nickname} 成功绑定为您的好友 ！",
                                ]
                            ]);
                            yii::error( '通知信息 :'.json_encode( $ret ) );
                         }
                    } catch (Exception $e) {
                        yii::error( $e->getMessage() );
                    }
                });
           }
                 //欢迎信息
                 $msg = <<<EOF
                 
客观，终于等到您了，欢迎关注人人麻将公众号！
首次关注请查看游戏使用说明、常见问题

点击：下载游戏

点击：提交BUG奖励元宝

点击：充值元宝

点击：代理后台

点击：邀请好友组局（生成自己专属二维码，推广下线）


我们正在招兵买马，全国范围内招收代理：代理可享受以下政策

可查看好友账单明细与提现等操作。
      
生成自己专属二维码，方便推广。

成功绑定下级，享受名下玩家消费返利。

免费培训，帮助代理躺着赚钱。
EOF;
            $ret = $entity->setResp([
                'FromUserName'=>$entity->ToUserName,
                'ToUserName'=>$entity->FromUserName,
                'MsgType'=>'text',
                'Content'=>$msg
            ]);
            yii::trace( json_encode( $ret ) );
        });
        
        //用户取消订阅
        $this->on('unsubscribe', function( $event ){
            $entity = $event->sender;
            $uInfo = UserService::getInstance()->getUserInfo([
                'open_id'=> $entity->FromUserName,
            ]);
            $ret = [];
            if( !empty( $uInfo ) )
                $ret = UserService::getInstance()->modifyUser([
                    'id'=> $uInfo->id,
                    'status'=> 2,
                ]);
            yii::error( json_encode( $ret ) );
        });
        
        //已关注用户扫码行为
        $this->on('scan', function( $event ){
            $entity = $event->sender;
            $id  = $entity->EventKey; 
            yii::error("myid: {$id}");
            //暂无行为;
        });
        
         //上报地理位置事件
        $this->on('location', function( $event ){
            //return "aaa";
        });
        
        //自定义菜单事件(点击菜单拉取消息时的事件推送)
        $this->on('click', function( $event ){
            $entity = $event->sender;
            $conf  = WeixinMenuConfig::getConf( $entity->EventKey );
            if( empty($conf) ){
                return $entity;
            }
            yii::error( $entity->EventKey);
            call_user_func_array([new $conf['class'], $conf['method']], [$entity] );
        });
        
        //自定义菜单事件(点击菜单跳转链接时的事件推送)
        $this->on('view', function( $event ){
            //return "aaa";
        });
    }
    
    
    /**
     * @param unknown $params
     */
    public function getEvent( $xmlStr ){
        if( empty( $xmlStr ) )
            throw new Exception(" invalid xml: {$xmlStr}");
        yii::error( "微信接口信息: ".$xmlStr );
        return new ProxyXml( simplexml_load_string( $xmlStr , 'SimpleXMLElement', LIBXML_NOCDATA) );
    }
    
    
}

class ProxyXml{
    private $xml = null;
    private $response = ' ';
    //需要添加<![CDATA[url]]> 元素列表
    const WRAP_LIST = ['ToUserName','FromUserName','MsgType','Content','MediaId',
        'Title','Description','MusicUrl','HQMusicUrl','ThumbMediaId','PicUrl','Url'];
    function __construct( $xmlObj = null ){
        $this->xml = $xmlObj;
    }
    function __get( $attr ){
        return isset( $this->xml->$attr ) ? trim( $this->xml->$attr ) : "";
    }
    
    function setResp( $data ){
        $default = [
            'CreateTime'=>ArrayHelper::getValue($_SERVER, 'REQUEST_TIME', time()),
        ];
        $this->response = $this->buildXml( array_merge($default,$data) ); 
    }
    
    function getResp() {
        return $this->response;
    }
    
    function buildXml( $data, $wrap= 'xml' ){
        $str = "<{$wrap}>";
        if( is_array( $data ) )
            if( !ArrayHelper::isIndexed( $data,true ) ){
                foreach( $data as $k=>$v ){
                    $str .= $this->buildXml( $v, $k  );
                }
            }else{
                foreach( $data as $v ){
                    foreach( $v as $k1=>$v1 )
                        $str .= $this->buildXml( $v1, $k1 );
                }
            }
        else
            $str .= $this->wrap( $wrap ,$data );
        $str .= "</{$wrap}>";
        return $str;
    }
   
    
    function wrap( $k, $v ){
         $formate = '%s';
        if( in_array( $k, ProxyXml::WRAP_LIST) )
            $formate = '<![CDATA[%s]]>';
        return sprintf( $formate,  $v );
    }
}

?>