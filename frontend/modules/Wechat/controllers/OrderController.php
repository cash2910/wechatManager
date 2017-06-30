<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use yii;
use common\service\order\OrderService;
use common\components\WeixinLoginBehavior;
use common\components\CommonResponse;
use common\models\MgUsers;
use common\models\MgGameGoods;
use common\models\MgOrderList;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `Wechat` module
 */
class OrderController extends Controller
{
    public $enableCsrfValidation = false;
    
    public $open_id = '';
    
    public function behaviors(){
        return [
            'access' => [
                'class' => WeixinLoginBehavior::className(),
                'actions' => [
           //          'get-order'
                ],
            ]
        ];
    }

    public function actionGetOrder(){
        $this->open_id = 'opjR8w4dyynJRHFhL8fFY9yrYG8M';
        $gid = (int)yii::$app->request->get('game_id', 0);
        if(!$gid)
            CommonResponse::end(['isOk'=>0,'msg'=>'invalid gid...']);
        $gObj = MgGameGoods::findOne(['id'=>$gid]);
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        
        $ret = OrderService::getInstance()->createOrder([
            'user_id'=>$uObj->id,
            'nick_name'=>$uObj->nickname,
            'game_id'=> $gObj->game_id,
            'entity_id'=>$gObj->id,
            'order_num' => $gObj->price,
            'channel'=>MgOrderList::WEIXIN_CHANNEL,
        ]);
        if( 1 ==  ArrayHelper::getValue($ret, 'isOk', 0 ) )
            $ret['data'] = $ret['data']->getAttributes();
        CommonResponse::end( $ret );
    }
}
