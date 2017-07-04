<?php
namespace common\service\order;

use yii;
use common\service\BaseService;
use common\service\OrderInterface;
use common\models\MgOrderList;
use common\models\MgOrderPayList;
use yii\base\Exception;
use yii\helpers\ArrayHelper;


class OrderService extends BaseService implements OrderInterface{
    
    const AFTER_CREATE_ORDER  = 'after_create_order';
    const AFTER_UPDATE_ORDER  = 'after_update_order';
    const AFTER_PAY_ORDER = 'after_pay_order';

    public function behaviors(){
        return [
            
        ];
    }
    
    public function createOrder( $params , \Closure $callback = null ){
        $ret = ['isOk'=>1,'msg'=>'订单创建成功','data'=>[]];        
        
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $this->ensureBehaviors();
            $orderObj = new MgOrderList();
            $orderObj->setAttributes( $params );
            $orderObj->order_sn = $this->genSn( $orderObj );
            if( !$orderObj->validate() )
                throw new \Exception( json_encode( $orderObj->getErrors() ) );
 
            $res = $orderObj->save();
            if( !$res )
                throw new \Exception( json_encode( $orderObj->getErrors() ) );
            if( $callback !== null ){
                call_user_func( $callback, $orderObj );
            }
            $transaction->commit();
            $this->trigger(self::AFTER_CREATE_ORDER);
            $ret['data'] = $orderObj;
        }catch ( \Exception $e){
            //savelog
            yii::error($e->getMessage());
            $transaction->rollBack();
        }
        return $ret;
        
    }
    
    public function updateOrder($params){
         
        $this->trigger(self::AFTER_UPDATE_ORDER);
    }
    
    public function payOrder( MgOrderList $orderObj, $params ){
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $this->ensureBehaviors();
            if(  $params['total_fee'] != ($orderObj->order_num*100) )
                throw new Exception('支付金额不匹配！');
            $orderObj->pay_sn = $params['transaction_id'];
            $orderObj->save();
            $payObj = new MgOrderPayList();
            $payObj->pay_sn = $params['transaction_id'];
            $payObj->order_sn = $orderObj->order_sn;
            $payObj->pay_type = ArrayHelper::getValue($params, 'pay_type', 2);
            $payObj->pay_num = $params['total_fee'];
            $payObj->save();
            $transaction->commit();
            $this->trigger(self::AFTER_PAY_ORDER);
        }catch( Exception $e ){
            yii::error($e->getMessage());
            $transaction->rollBack();
            return false;
        }
        return true;   
    }
    
    /**
     * 创建订单号
     */
    public function genSn( $order ){
        if( !$order->user_id )
            throw new \Exception( "can't find user_id ... " );
        return date('YmdHis').substr( $order->user_id, 0,3 ).mt_rand(100, 999);
    }
    
}

?>