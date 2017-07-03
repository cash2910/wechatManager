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
/* use common\components\wxpay\WxPayUnifiedOrder;
use common\components\wxpay\WxPayApi;
use common\components\wxpay\WxPayJsApiPay; */
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayApi.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayDataBase.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayJsApiPay.php';



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
                     'get-order'
                ],
            ]
        ];
    }

    /**
     * 创建订单 并生成微信支付单
     */
    public function actionGetOrder(){
        $this->open_id = 'opjR8w4dyynJRHFhL8fFY9yrYG8M';
        $gid = (int)yii::$app->request->get('gid', 0);
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
        if( 1 !=  ArrayHelper::getValue($ret, 'isOk' ) )
            CommonResponse::end( ['isOk'=>0,'msg'=>'创建订单失败...'] );
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("支付充值".$ret['data']->order_num);
        $input->SetAttach( $ret['data']->id );
        $input->SetOut_trade_no(  $ret['data']->order_sn  );
        $input->SetTotal_fee( $ret['data']->order_num );
        $input->SetTime_start( date("YmdHis") );
        $input->SetTime_expire( date("YmdHis", time() + 600));
        $input->SetGoods_tag( "test" );
        $input->SetNotify_url( yii::$app->urlManager->createAbsoluteUrl('/Wechat/order/notify') );
        $input->SetTrade_type( "JSAPI" );
        $input->SetOpenid( $this->open_id );
        
        $input->SetAppid( yii::$app->params['AppId'] );
        $input->SetMch_id( yii::$app->params['AppSecret'] );
        //$inputObj->SetAppid(WxPayConfig::APPID);//公众账号ID
        //$inputObj->SetMch_id(WxPayConfig::MCHID);//商户号
        
        $order = \WxPayApi::unifiedOrder( $input );
        
        $tools = new \JsApiPay();
        $param = $tools->GetJsApiParameters( $order );
            //$ret['data'] = $ret['data']->getAttributes();
        CommonResponse::end( ['isOk'=>0,'data'=>$param ] );
    }
    
    
    public function actionNotify(){
        
    }
}
