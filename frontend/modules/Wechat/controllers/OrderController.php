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


require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayException.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayConfig.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayApi.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayDataBase.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayJsApiPay.php';
require_once dirname(dirname(dirname(dirname( __DIR__ )))).'/common/components/wxpay/WxPayNotify.php';




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
        $input->SetTotal_fee( $ret['data']->order_num*100 );
        $input->SetTime_start( date("YmdHis") );
        //$input->SetTime_expire( date("YmdHis", time() + 1200));
        $input->SetGoods_tag( "test" );
        $input->SetNotify_url( yii::$app->urlManager->createAbsoluteUrl('/Wechat/order/notify') );
        $input->SetTrade_type( "JSAPI" );
        $input->SetOpenid( $this->open_id );
        
        $input->SetAppid( yii::$app->params['AppId'] );
        $input->SetMch_id( yii::$app->params['MCHID'] );
        
        $order = \WxPayApi::unifiedOrder( $input );
        if( 'FAIL' == $order['return_code'] ){
            yii::error( json_encode( $order ) );
            CommonResponse::end( ['isOk'=>0,'msg'=>'创建微信付款单失败...'] );
        }
        $tools = new \JsApiPay();
        $param = $tools->GetJsApiParameters( $order );
        CommonResponse::end( ['isOk'=>1,'data'=>json_decode( $param, true ) ] );
    }
    
    
    public function actionNotify(){
        
        
        
        
    }
}
