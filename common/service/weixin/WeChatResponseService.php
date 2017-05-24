<?php
namespace common\service\weixin;

use yii\base\Module;
use yii\base\Exception;
use service\users\UserService;
use yii\base\Event;
use yii;
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
        $eventName = $eventObj->MsgType;
        if( $eventObj->MsgType == 'event' )
            $eventName = $eventObj->Event;
        var_dump( $eventName );
        $this->trigger( $eventName , $event );
        return $eventObj;
        
    }
    
    public function init(){
        //接收普通消息  text image ...
        $this->on('text', function( $event ){
            return "aaa";
        });
        
        //用户订阅 ...
        $this->on('subscribe', function( $event ){
            $entity = $event->sender;
            $ret = UserService::getInstance()->createUser([
                'add_time'=> $entity->CreateTime,
                'event_key'=>$entity->EventKey,
                'open_id' => $entity->FromUserName,
                'ticket' => $entity->Ticket
            ]);
                        
        });
        
        //接收普通消息  text image ...
        $this->on('unsubscribe', function( $event ){
            return "aaa";
        });
        
        //已关注用户扫码行为
        $this->on('SCAN', function( $event ){
            return "aaa";
        });
        
         //上报地理位置事件
        $this->on('LOCATION', function( $event ){
            return "aaa";
        });
        
        //自定义菜单事件(点击菜单拉取消息时的事件推送)
        $this->on('CLICK', function( $event ){
            return "aaa";
        });
        
        //自定义菜单事件(点击菜单跳转链接时的事件推送)
        $this->on('VIEW', function( $event ){
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
    function __construct( $xmlObj = null ){
        $this->xml = $xmlObj;
    }
    function __get( $attr ){
        return isset( $this->xml[$attr] ) ? trim( $this->xml[$attr] ) : "";
    }
    
    function setResp( $str ){
        $this->response = $str;
    }
    
    function getResp() {
        return $this->response;
    }
}

?>