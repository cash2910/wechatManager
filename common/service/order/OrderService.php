<?php
namespace common\service\order;
use common\service\BaseService;
use common\service\OrderInterface;
use common\models\MgOrderList;
use yii\validators\RangeValidator;
use yii\base\Exception;

class OrderService extends BaseService implements OrderInterface{
    
    const AFTER_CREATE_ORDER  = 'after_create_order';
    const AFTER_UPDATE_ORDER  = 'after_update_order';

    public function createOrder( $params , \Closure $callback = null ){
        $ret = ['isOk'=>1,'msg'=>'订单创建成功','data'=>[]];        
        $transaction = Yii::$app->db->beginTransaction();
        try{
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
            $ret['data'] = $ret;
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
    
    /**
     * 创建订单号
     */
    public function genSn( $order ){
        if( !$order->user_id )
            throw new \Exception( "can't find user_id ... " );
        return date('Y-m-dHis').substr( $order->user_id, 0,3 ).mt_rand(100, 999);
    }
    
}

?>