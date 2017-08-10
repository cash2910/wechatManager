<?php
namespace common\components\order;

use yii;
use yii\base\Behavior;
use common\models\MgOrderList;
use common\models\MgUsers;
use common\models\MgUserAccount;
use common\models\MgUserAccountLog;
use common\service\weixin\WeChatService;
use common\models\MgUserRel;
/**
 * @param MgOrderList $order_obj
 */
class BalanceBehavior extends Behavior{

    //默认返利用户
    const DEFAULT_UID = 94;
    /**
     * 订单金额小于1元不进行返利
     * 1、获取返利用户
     * 2、创建返利单 并将返利添加入用户账户
     * @param MgOrderList $order_obj
     */
    public function doBalance( MgOrderList $order_obj ){
        //if( $order_obj->order_num < 1)
        //    return false;
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $uInfo = MgUsers::findOne([ 'id'=>$order_obj->user_id ]);
            $refund = [
                0=>0.5,
                1=>0.07,
                2=>0.03
            ];
            $total = $order_obj->order_num;
            $rel = $uInfo->user_rels;
            $uids = array_reverse( explode("-", $rel) );
            $data = [];
            for( $i=0; $i <= (count( $refund ) -1); $i++ ){
                $_uid = self::DEFAULT_UID;
                $ratio = $refund[$i];
                $_refund = $ratio*$total;
                if( isset( $uids[$i] ) && !empty( $uids[$i] ) )
                    $_uid = $uids[$i];
                //累加计算
                if( isset( $data[$_uid] ) ){
                    $_refund += $data[$_uid]['refund'];
                    $ratio += $data[$_uid]['ratio'];
                }
                $data[$_uid] = ['uid'=> $_uid, 'refund'=>$_refund , 'ratio'=>$ratio  ];       
            }
            $this->genRefund( $data, $order_obj , $uInfo );
            $transaction->commit();

                            
        }catch ( \Exception $e ){
            //var_dump( $e->getMessage() );
            $transaction->rollBack();
            yii::error( "返利失败： ".$e->getMessage() );
        }
    }
    
    /**
     * 添加返利记录
     * @param unknown $data
     */
    private function genRefund( $data , MgOrderList $order_obj, MgUsers $uObj  ){
        
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
            //通知用户
            $uInfo = MgUserRel::findOne(['user_id'=>$uid]);
            if( $uInfo ){
                 $ret = WeChatService::getIns()->sendCsMsg([
                    'touser'=> $uInfo->user_openid,
                    'msgtype'=>'text',
                    'text'=>[
                         'content'=> "恭喜您成功获得{$uObj->nickname}充值返利 : {$d['refund']} 元！~"
                    ]
                ]);
            }
        }
        $ret = yii::$app->db->createCommand()->batchInsert( MgUserAccountLog::tableName(), [
            'user_id','num','c_type', 'add_time','content'
        ], $infos )->execute();
    }
    
}

?>