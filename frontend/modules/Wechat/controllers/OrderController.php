<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use yii;
use common\service\order\OrderService;
use yii\base\Exception;
use common\components\CommonResponse;

/**
 * Default controller for the `Wechat` module
 */
class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionGetOrder(){
        
        //$gid = (int)yii::$app->request->get('gid', 0);
        //if(!$gid)
        //    CommonResponse::end(['isOk'=>0,'msg'=>'invalid gid...']);
        
        OrderService::getInstance()->createOrder([
            
        ]);
        
    }
}
