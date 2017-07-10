<?php
namespace common\components\order;

use yii;
use yii\base\Behavior;
use common\models\MgOrderList;
use common\models\MgUsers;
use common\components\game\Stone;
use common\models\MgGameGoods;
use common\models\MgUserAccount;
use common\models\MgUserAccountLog;
use yii\base\Object;
use yii\base\Exception;
/**

 * @param MgOrderList $order_obj
 */
class BalanceBehavior extends Behavior{

    //默认返利用户
    const DEFAULT_UID = 19;
    /**
     * 1、获取返利用户
     * 2、创建返利单 并将返利添加入用户账户
     * @param MgOrderList $order_obj
     */
    public function doBalance( MgOrderList $order_obj ){
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $uInfo = MgUsers::findOne([ 'id'=>$order_obj->user_id ]);
            $refund = [
                0=>0.2,
                1=>0.3,
                2=>0.4
            ];
            $total = $order_obj->order_num;
            $rel = $uInfo->user_rels;
            $uids = array_reverse( explode("-", $rel) );
            $data = [];
            for( $i=0; $i <=2; $i++ ){
                $_uid = self::DEFAULT_UID;
                $ratio = $refund[$i];
                $_refund = $ratio*$total;
                if( isset( $uids[$i] ) )
                    $_uid = $uids[$i];
                //累加计算
                if( isset( $data[$_uid] ) ){
                    $_refund += $data[$_uid]['refund'];
                    $ratio += $data[$_uid]['ratio'];
                }
                $data[$_uid] = ['uid'=> $_uid, 'refund'=>$_refund , 'ratio'=>$ratio ];       
            }
            $this->genRefund( $data, $order_obj );
            $transaction->commit();
            //通知用户
                            
        }catch ( \Exception $e ){
            //var_dump( $e->getMessage() );
            $transaction->rollBack();
            yii::error( $e->getMessage() );
        }
    }
    
    /**
     * 添加返利记录
     * @param unknown $data
     */
    private function genRefund( $data , MgOrderList $order_obj ){
        
        $infos = []; $t = date('Y-m-d H:i:s' );
        foreach ( $data as $uid => $d ){
            $u = MgUserAccount::findOne( [ 'user_id'=>$uid ] );
            if( !$u ){
                $u = new MgUserAccount();
                $u->user_id = $uid;
                $u->free_balance = $d['refund'];
            }else{
                $u->free_balance += $d['refund'];
            }
            $u->update_time = $t;
            $r = $u->save();
            if( !$r )
                throw new \Exception( "返利error:".json_encode( $u->getErrors() ) );
            $infos[] = [$d['uid'],  $d['refund'] , 1, $t , "返利订单：{$order_obj->order_sn}, 返利比例{$d['ratio']}" ];
        }
        $ret = yii::$app->db->createCommand()->batchInsert( MgUserAccountLog::tableName(), [
            'user_id','num','c_type', 'add_time','content'
        ], $infos )->execute();
    }
    
}

?>