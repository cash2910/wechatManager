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
use common\models\MgUserAccount;
use common\service\order\RebateService;

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
                     'get-order', 'get-rebate'
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
            'order_desc'=> "购买商品{$gObj->title}",
            'order_num' => $gObj->price,
            'channel'=>MgOrderList::WEIXIN_CHANNEL,
        ]);
        if( 1 !=  ArrayHelper::getValue($ret, 'isOk' ) )
            CommonResponse::end( ['isOk'=>0,'msg'=>'创建订单失败...'] );
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("游戏充值".$ret['data']->order_num);
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
        
        $msg = 'OK';
        $ret = \WxpayApi::notify( array($this, 'NotifyCallBack'), $msg );
        if( !$ret ){
            yii::error( $msg );
        }
        $reply = new \WxPayNotify();
        if( $ret  == false){
			$reply->SetReturn_code("FAIL");
			$reply->SetReturn_msg($msg);
		} else {
			//该分支在成功回调到NotifyCallBack方法，处理完成之后流程
			$reply->SetReturn_code("SUCCESS");
			$reply->SetReturn_msg("OK");
		}
		yii::error($reply->ToXml());
		\WxpayApi::replyNotify($reply->ToXml());
    }
    
    /**
     * {"appid":"wxc41b5bd89d328132","attach":"188","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"Y","mch_id":"1483656542","nonce_str":"p1q8yvo9jlbq2u6r6aw2trk5jwquhot4","openid":"o9Unv0a0sL-H8lREpQ86O5WodVyg","out_trade_no":"2017070406550682505","result_code":"SUCCESS","return_code":"SUCCESS","sign":"AA6424FE06FD7E085398E15FFE1916C3","time_end":"20170704145510","total_fee":"1","trade_type":"JSAPI","transaction_id":"4000632001201707048856347475"}
     * @param unknown $result
     */
    public function NotifyCallBack( $result ){
        
        $order_sn = $result['out_trade_no'];
        $orderObj = MgOrderList::findOne([ 'order_sn'=> $order_sn ]);
        if( !$orderObj ){
            yii::error( "未找到订单信息：".json_encode($result));
            return false;            
        }
        $ret = OrderService::getInstance()->payOrder( $orderObj , $result );
        //yii::error(json_encode($result));
        return true;   
    }
    
    /**
     * 一次性提走全部返利
     */
    public function actionGetRebate(){
        $uObj = MgUsers::findOne( [ 'open_id'=>$this->open_id ] );
        $aObj = MgUserAccount::findOne(['user_id'=>$uObj->id]);
        if( !$aObj || $aObj->free_balance < 1 )
            CommonResponse::end( ['isOk'=>0,'msg'=>'提现金额不足' ] );
        $ret = RebateService::getInstance()->createRebateOrder( $aObj , $aObj->free_balance );
        if( $ret['isOk'] ){
            $ret['msg'] = '提现成功 ,请等待管理员审核...';
            $ret['data'] = json_encode( $ret['data']->getAttributes() );
        }
        CommonResponse::end( $ret );
    }
}
