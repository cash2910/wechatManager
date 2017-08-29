<?php
namespace common\components;

use yii;
use yii\base\ActionFilter;
class WeixinLoginBehavior extends ActionFilter{
    
    public $actions = [];
    public $detail_actions = [];
    public function beforeAction($action)
    {
        //测试用途；
         if( in_array( Yii::$app->request->userIP, ['127.0.0.1'] ) ){
            $this->owner->open_id = 'o9Unv0a0sL-H8lREpQ86O5WodVyg';
            //$this->owner->open_id = 'o9Unv0RVvjPNBhde4LI68AYoRUiA';
            return true;
        } 
        if( !in_array( $action->id, $this->actions ) )
            return true;
        $token = WeixinWeb::getInstance()->getClient()->getAccessToken();
        if( !$token ){
            $url =  Yii::$app->urlManager->createAbsoluteUrl(['/Wechat','r_url'=> yii::$app->request->url  ] ); 
            $clientObj = WeixinWeb::getInstance()->getClient();
            $clientObj->setReturnUrl( $url );
            if( in_array( $action->id, $this->detail_actions ) )
                $clientObj->scope = 'snsapi_userinfo';
            $returl =  $clientObj->buildAuthUrl();
            Yii::$app->getResponse()->redirect( $returl );
            return false;
        }
        if( isset( $this->owner->open_id ) ){
            $this->owner->open_id = $token->getParam('open_id');
        }
        if( isset($this->owner->user_data ) ){
            $this->owner->user_data = $token->getParam('all_data');
        }
        return true;
    }
}

?>