<?php
namespace common\components;

use yii;
use yii\base\ActionFilter;
class WeixinLoginBehavior extends ActionFilter{
    
    public $actions = [];
    public function beforeAction($action)
    {
        //测试用途；
        if( in_array( Yii::$app->request->userIP, ['127.0.0.1'] ) ){
            $this->owner->open_id = 'o9Unv0a0sL-H8lREpQ86O5WodVyg';
           // $this->owner->open_id = 'o9Unv0RVvjPNBhde4LI68AYoRUiA';
            return true;
        }
        if( !in_array( $action->id, $this->actions ) )
            return true;
        $token = WeixinWeb::getInstance()->getClient()->getAccessToken();
        if( !$token ){
            $url = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat','r_url'=>$this->actions ] );
            WeixinWeb::getInstance()->getClient()->setReturnUrl( $url );
            $returl =  WeixinWeb::getInstance()->getClient()->buildAuthUrl();
            Yii::$app->getResponse()->redirect( $returl );
            return false;
        }
        if( isset( $this->owner->open_id ) )
            $this->owner->open_id = $token->getParam('open_id');
        return true;
    }
}

?>