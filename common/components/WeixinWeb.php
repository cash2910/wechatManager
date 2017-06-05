<?php
namespace common\components;

use yii;
use yii\helpers\ArrayHelper;
use common\components\WeixinAuthClient;
use common\service\BaseService;
/**
 * 微信配置方法
 * @author zaixing.jiang
 *
 */
class WeixinWeb extends BaseService{
    
    private $userInfo = null;
    private $clientObj = null;
    
    private function getClient(){
        if( $this->clientObj == null )
            $this->clientObj = new WeixinAuthClient();
        return $this->clientObj;
    }
    
    public function getUserInfo(){
        if( null == $this->userInfo ){
            $client = $this->getClient();
             $url =  $client->buildAuthUrl(['scope'=>'snsapi_userinfo']);
             Yii::$app->getResponse()->redirect($url);
        }
        return $this->userInfo;
    }
    
    //设置返回链接    
    public function setRetUrl( $url ){
        return $this->getClient()->setReturnUrl( $url );
    }
    
    public function getToken( $code  ){
        $client = $this->getClient();
        $accessToken = $client->fetchAccessToken( $code );
    }
    
    
}

?>