<?php
namespace common\components;

use yii;
use yii\base\ActionFilter;
class WeixinLoginBehavior extends ActionFilter{
    
    public $actions = [];
    public function beforeAction($action)
    {
        if( !in_array( $action->id, $this->actions ) )
            return true;
        $token = WeixinWeb::getInstance()->getClient()->getAccessToken();
        if( !$token ){
            $url = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat'] );
            $wbServ =  WeixinWeb::getInstance()->getClient()->setReturnUrl( $url );
            Yii::$app->getResponse()->redirect($url);
            return false;
        }
        return true;
    }
}

?>