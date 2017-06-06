<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use common\service\weixin\BusinessService;
use yii;
use common\components\WeixinWeb;
use common\components\WeixinLoginBehavior;
use common\models\MgUsers;
use common\models\MgUserRel;

/**
 * Default controller for the `Wechat` module
 */
class DefaultController extends Controller
{
    public $layout = "main_wx";
    public $open_id = '';
    
    public function behaviors(){
        return [
            'access' => [
                'class' => WeixinLoginBehavior::className(),
                'actions' => [
                    'my-index','my-friend','my-order'
                ],
            ]
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if( !( $code = yii::$app->request->get('code') ) ){
            die('访问受限');
        }
        $token = WeixinWeb::getInstance()->getClient()->fetchAccessToken( $code );
        Yii::$app->getResponse()->redirect( Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/default/my-index'] ) );
    }
    
    public function actionSharePage()
    {
        return $this->renderPartial('share_page');
    }
    

    
    public function actionGamePage()
    {
        return $this->renderPartial('game_page');
    }
    
    /**
     * MG推广首页
     * @return string
     */
    public function actionMyIndex()
    {
        //$this->open_id = 'opjR8w4dyynJRHFhL8fFY9yrYG8M';
        //判断用户是否为mg用户   
        $mgInfo = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $mgInfo == null ){
            die('访问受限');
        }
        return $this->render('my_index',[
            'user'=>$mgInfo
        ]);
    }
    
    //我的下线列表
    public function actionMyFriend()
    {
        //$this->open_id = 'opjR8w4dyynJRHFhL8fFY9yrYG8M';
        $mgInfo = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $mgInfo == null ){
            die('访问受限');
        }
        $ids = [];
        $subObjs = MgUserRel::findAll( ['user_id'=>$mgInfo->id] );
        foreach( $subObjs as $subObj){
            $ids[] = $subObj->sub_user_id;
        }
        $subs = MgUsers::findAll( ['id'=>$ids] );
        return $this->render('my_friend', [
            'subs'=> $subs
        ]);
    }
    
    //我的订单列表
    public function actionMyOrder()
    {
        return $this->render('my_order');
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
