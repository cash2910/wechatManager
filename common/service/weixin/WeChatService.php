<?php
namespace common\service\weixin;

use common\service\WeixinInterface;

class WeChatService implements WeixinInterface
{
    static public $Ins = null;
    protected  $proxy = null;
    
    static public function getIns( $proxy = null ){
        if( !self::$Ins ){
            self::$Ins = new WeChatService( $proxy );
        }
        return self::$Ins;
    }
    
    private function __construct( $proxy = null ){
        if( $proxy == null )
            $proxy  = new WeChatProxyService();
        $this->proxy = $proxy;
    }
    
    /**
     * 先获取缓存中数据。若没有则向微信端获取
     * @see \service\WeixinInterface::getAccessToken()
     */
    public function getAccessToken( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);       
    }
        
    public function getCallbackIp(){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function getMenu(){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function getUserTag(){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function createUserTag( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function updateUserTag( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function deleteUserTag( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function getUsers( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function batchGetUsersInfo( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function getUserInfo( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function createQrcode( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }

    public function genShortUrl( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function createMenu( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function setIndustry( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
    
    public function sendMsg( $params ){
        list( $nsp, $method ) = explode('::', __METHOD__ );
        return call_user_func([ $this->proxy, $method ],$params);
    }
}

?>