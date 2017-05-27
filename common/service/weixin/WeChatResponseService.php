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
/*             $conf  = WeixinMenuConfig::getConf( 'GET_SHARE_QRCODE' );
            if( empty($conf) ){
                return $entity;
            }
            call_user_func_array([new $conf['class'], $conf['method']], [$entity] ); */
            $entity->setResp([
                'FromUserName'=>$entity->ToUserName,
                'ToUserName'=>$entity->FromUserName,
                'MsgType'=>'text',
                'Content'=>'【你好】'
            ]);
            
            /* 
            $conf  = WeixinMenuConfig::getConf( $entity->EventKey );
            if( empty($conf) ){
                return $entity;
            }
            call_user_func_array([new $conf['class'], $conf['method']], [$entity] ); */
        });
        /**
         * 用户订阅 ...
         * 获取推广id, 创建用户 并绑定关系
         */
        $this->on('subscribe', function( $event ){
            $entity = $event->sender;
            $id  = $entity->EventKey; //上级id
            //判断用户是否存在
            
            $ret = UserService::getInstance()->createUser([
                'add_time'=> $entity->CreateTime,
                'open_id' =>  $entity->FromUserName,
                'ticket' => $entity->Ticket
            ],function( $model ) use ( $id, $entity ){
                //若不存在招募关系 则不进行关系绑定
                if( empty( $id ) )
                    return false;
                try {
                    list( $p, $id ) = explode("_",$id);
                    $uInfo = \common\service\users\UserService::getInstance()->getUserInfo([
                        'id'=> $id
                    ]);
                    if( empty($uInfo)  )
                        throw new Exception(" invalid scran ID");
                    $rel = $uInfo->user_rels;
                    $model->user_rels = !empty( $rel ) ? ( $rel."-".$uInfo->id ) : $uInfo->id ;
                    $model->on( ActiveRecord::EVENT_AFTER_INSERT, function( $ent ) use ( $id ){
                        $rel = new MgUserRel();
                        $rel->user_id = $id;
                        $rel->sub_user_id = $ent->sender->id;
                        $rel->save();
                    });
                    //通知用户
                    $entity->setResp([
                        'FromUserName'=> $entity->ToUserName,
                        'ToUserName'=>$uInfo->open_id,
                        'Content'=>"{$uInfo->open_id} 好！！",
                        'MsgType' =>'text',
                    ]);
                } catch (Exception $e) {
                    yii::error( $e->getMessage() );
                }
            });
            yii::trace( json_encode( $ret ) );
        });
        
        //接收普通消息  text image ...
        $this->on('unsubscribe', function( $event ){
            $entity = $event->sender;
            
            $ret = UserService::getInstance()->getUserInfo([
                'open_id'=> $entity->FromUserName,
            ]);
            if( !empty($ret) )
                $ret = UserService::getInstance()->modifyUser([
                    'id'=> $ret->id,
                    'status'=> 2,
                    'update_time'=> $entity->CreateTime
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
            return "aaa";
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
            return "aaa";
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
        //    'FromUserName'=> Yii::$app->params['AppId']
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