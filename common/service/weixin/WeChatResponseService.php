<?php
namespace common\service\weixin;

use yii\base\Module;
use yii\base\Exception;
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
        $this->trigger( $eventObj->MsgType , $event );
        return $eventObj;
        
    }
    
    public function init(){
        //接收普通消息  text image ...
        $this->on('text', function( $event ){
            return "aaa";
        });
        
        //接收事件推送
        $this->on('event', function( $event ){
            $res = "";
            switch ( $event->sender->Event ){
                //用户扫码行为
                case 'subscribe':
                    break;
                case 'SCAN':
                    break;
                //上报地理位置事件
                case 'LOCATION':
                    break;
                //自定义菜单事件(点击菜单拉取消息时的事件推送)
                case 'CLICK':
                    break;
                //自定义菜单事件(点击菜单跳转链接时的事件推送)
                case 'VIEW':
                    break;
                default:
                    break;
            }
            $event->sender->setResp( $res );
            return true;
            
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
    private $response = '';
    function __construct( $xmlObj = null ){
        $this->xml = $xmlObj;
    }
    function __get( $attr ){
        return isset( $this->xml[$arr] ) ? trim( $this->xml[$arr] ) : "";
    }
    
    function setResp( $str ){
        $this->response = $str;
    }
    
    function getResp() {
        return $this->response;
    }
}

?>