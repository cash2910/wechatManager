<?php
namespace common\service\order;
use yii;
use common\service\BaseService;
use common\models\MgUserAccount;
use common\models\MgRebateList;
use yii\base\Exception;


class RebateService extends BaseService {
    
    private $orderObj = null;
    
    public function behaviors(){
        return [
            
        ];
    }
    
    /**
     * 
     * @param MgUserAccount $account  提现账户
     * @param int $num                提现金额
     * @throws \Exception
     */
    public function createRebateOrder( MgUserAccount $account, $num ){
        
        $ret = ['isOk'=>0,'msg'=>'创建提现单失败','data'=>[]]; 
        if( $account->free_balance < $num ){
            $ret['msg'] = "账户余额不足 {$num}";
            return $ret;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $rebateObj = new MgRebateList();
            $rebateObj->rebate_sn = $this->genSn( $account->user_id );
            $rebateObj->user_id = $account->user_id;
            $rebateObj->status = MgRebateList::APPLY;
            $rebateObj->desc = "用户提现： ¥{$num}" ;
            $rebateObj->rebate_num = $num;
            $ret = $rebateObj->save();
            if( !$ret )
                throw new \Exception( json_encode( $rebateObj->getErrors() ) );
            $account->free_balance -= $num;
            $account->save();
            
            $transaction->commit();
            $this->orderObj = $orderObj;
            $ret = [
                'isOk'=>1,
                'msg' =>'创建提款单成功！',
                'data'=>$rebateObj
            ];
        }catch ( \Exception $e){
            //savelog
            yii::error($e->getMessage());
            $transaction->rollBack();
        }
        return $ret;
    }
    
    /**
     * 创建提款单号
     */
    public function genSn( $uid ){
        return date('YmdHis').substr( $uid, 0,3 ).mt_rand(100, 999);
    }
    
}

?>