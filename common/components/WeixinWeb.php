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
    
    public function getClient(){
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
    
}

?>