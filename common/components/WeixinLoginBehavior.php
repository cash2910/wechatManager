<?php
namespace common\components;

use yii;
use yii\base\ActionFilter;
use yii\helpers\ArrayHelper;
class WeixinLoginBehavior extends ActionFilter{
    
    public $actions = [];
    public function beforeAction($action)
    {
        if( !in_array( $action->id, $this->actions ) )
            return true;
        $client = WeixinWeb::getInstance()->getClient();
        $uInfo = $client->getState('user_info');
        if( ArrayHelper::getValue($uInfo, 'union_id') ){
            $this->owner->open_id = $uInfo['open_id'];
            $this->owner->union_id = $uInfo['union_id'];
            return true;
        }
        $token = $client->getAccessToken();
        if( !$token ){
            //通过oauth获取用户token
            $url = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat'] );
            $client->setReturnUrl( $url );
            $returl =  $client->buildAuthUrl();
            Yii::$app->getResponse()->redirect( $returl );
            return false;
        }
        $uInfo = $client->getUserInfo( $token );
        
        $client->setState('user_info',[
            'open_id'=> $uInfo['open_id'],
            'union_id'=> $uInfo['union_id']
        ]);
        
        return true;
    }
}

?>