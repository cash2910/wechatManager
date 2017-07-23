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
                $entity->setResp([
                    'FromUserName'=>$entity->ToUserName,
                    'ToUserName'=>$entity->FromUserName,
                    'MsgType'=>'transfer_customer_service',
                    'TransInfo'=>[
                        'KfAccount'=>''
                    ]
                ]);
                yii::error( "cs: ".$entity->FromUserName );
                return ;
            }
            $entity->setResp([
                'FromUserName'=>$entity->ToUserName,
                'ToUserName'=>$entity->FromUserName,
                'MsgType'=>'text',
                'Content'=>'【你好】'
            ]);
        });
        /**
         * 用户订阅 ...
         * 获取推广id, 创建用户 并绑定关系
         */
        $this->on('subscribe', function( $event ){
            $entity = $event->sender;
            $id  = $entity->EventKey; //上级id
            $open_id =  $entity->FromUserName;
            $uServ = UserService::getInstance();
            //判断用户是否存在
            if( $uServ->checkExist(  $entity->FromUserName ) ){
                //savelog...
                $ret = UserService::getInstance()->modifyUser([
                    'open_id'=> $open_id,
                    'status'=> 1,
                ]);
                //通知用户
                $entity->setResp([
                    'FromUserName'=> $entity->ToUserName,
                    'ToUserName'=> $open_id,
                    'Content'=>"欢迎回来~",
                    'MsgType' =>'text',
                ]);
                return true;
            }
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
                'ticket' => $entity->Ticket
            ],function( $model ) use ( $id, $entity ){
                //若不存在招募关系 则不进行关系绑定
                if( empty( $id ) )
                    return false;
                try {
                    list( $p, $id ) = explode("_",$id);
                    //获取招募人信息
                    $uInfo = \common\service\users\UserService::getInstance()->getUserInfo([
                        'id'=> $id
                    ]);
                    if( empty($uInfo)  )
                        throw new Exception(" invalid scran ID");
                    $rel = empty( $uInfo->user_rels ) ? (string)$uInfo->id : ( $uInfo->user_rels.'-'.$uInfo->id );
                    $model->user_rels = $rel;
                    yii::error("rel :".$model->user_rels );
                    $model->on( ActiveRecord::EVENT_AFTER_INSERT, function( $ent ) use ( $id, $model, $uInfo ){
                        $rel = new MgUserRel();
                        $rel->user_id = $id;
                        $rel->sub_user_id = $ent->sender->id;
                        $rel->user_openid = $uInfo->openid;
                        $rel->sub_user_openid = $model->openid;
                        $rel->save();
                    });
                    //通知上线用户 
                    $ret = WeChatService::getIns()->sendCsMsg([
                        'touser'=> $uInfo->open_id ,
                        'msgtype'=>'text',
                        'text'=>[
                            'content'=> "{$model->nickname} 成功绑定为您的好友 ！",
                        ]
                    ]);
                    yii::error( '通知信息 :'.json_encode( $ret ) );
                } catch (Exception $e) {
                    yii::error( $e->getMessage() );
                }
            });
            //通知用户
            $entity->setResp([
                'FromUserName'=> $entity->ToUserName,
                'ToUserName'=> $open_id,
                'Content'=>"欢迎加入MG竞技",
                'MsgType' =>'text',
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