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
            $returl =  WeixinWeb::getInstance()->getClient()->setReturnUrl( $url )->buildAuthUrl();
            Yii::$app->getResponse()->redirect($returl);
            return false;
        }
        return true;
    }
}

?>