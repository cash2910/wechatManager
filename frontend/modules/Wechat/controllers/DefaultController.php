<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use common\service\weixin\BusinessService;
use yii;

/**
 * Default controller for the `Wechat` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
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
    
    public function actionMyFriend()
    {
        return $this->renderPartial('my_friend');
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
