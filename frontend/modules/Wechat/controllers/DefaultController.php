<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use common\service\weixin\BusinessService;
use yii;
use common\components\WeixinWeb;

/**
 * Default controller for the `Wechat` module
 */
class DefaultController extends Controller
{
    public $layout = "main_wx";
    
 //   public function 
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if( !( $code = yii::$app->request->get('code') ) ){
            $wbServ =  WeixinWeb::getInstance();
            $wbServ->setRetUrl( Yii::$app->urlManager->createAbsoluteUrl(['/Wechat'] ) );
            $wbServ->getUserInfo();
        }else{
            $wbServ =  WeixinWeb::getInstance();
            $token = $wbServ->getToken( $code );
            var_dump( $token );
            die();
        }
        return $this->render('index');
    }
    
    public function actionSharePage()
    {
        return $this->renderPartial('share_page');
    }
    
    public function actionGamePage()
    {
        return $this->renderPartial('game_page');
    }
    
    public function actionMyIndex()
    {
        return $this->render('my_index');
    }
    
    public function actionMyFriend()
    {
        return $this->render('my_friend');
    }
    
    
    public function actionGetQrCode(){
        $id = yii::$app->request->get('id', 0);
        $url = BusinessService::getInstance()->getQrcode( $id );
        die(json_encode([
            'isOk'=> 1,
            'msg' => '获取成功',
            'pic_url'=>$url
        ]));
    }
}
