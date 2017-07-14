<?php
namespace common\service\order;
use yii;
use common\service\BaseService;
use common\models\MgUserAccount;
use common\models\MgRebateList;
use yii\base\Exception;
use common\components\wxtransfer\WeixinTransfer;
use common\models\MgUsers;
use common\models\TransferEntity;

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
            $res = $rebateObj->save();
            if( !$res )
                throw new \Exception( json_encode( $rebateObj->getErrors() ) );
            $account->free_balance -= $num;
            $res = $account->save();
            if( !$res )
                throw new \Exception( json_encode( $rebateObj->getErrors() ) );
            //添加提现记录到accountlog
            
            
            $transaction->commit();
            $this->orderObj = $rebateObj;
            $ret = [
                'isOk'=>1,
                'msg' =>'创建提款单成功！',
                'data'=>$rebateObj
            ];
        }catch ( \Exception $e){
            //savelog
            //var_dump( $e->getMessage() );
            yii::error($e->getMessage());
            $transaction->rollBack();
        }
        return $ret;
    }
    
    /**
     * 通过提现
     * 1、检测状态
     * 2、给用户转账
     * 3、修改提现订单状态
     */
    public function applyRebate( MgRebateList $rObj ){
        $ret = ['isOk'=>1, 'msg'=>'审核通过！'];        
        try{
            if( $rObj->status !== MgRebateList::APPLY )
                throw new Exception('提款单状态有误！');
            $entity = new TransferEntity();
            $uInfo = MgUsers::findOne( ['id'=>$rObj->user_id ] );
            if( !$uInfo )
                throw new Exception('用户信息有误！');
            $num = intval( $rObj->rebate_num*100 );
            $entity->setAttributes([
                'partner_trade_no'=> $rObj->rebate_sn ,
                'openid'=> $uInfo->open_id,
                'check_name'=>'NO_CHECK',
                'amount'=> $num, 
                'desc'=> "用户提现￥{$rObj->rebate_num}",
                'spbill_create_ip'=>'127.0.0.1',
            ]);
            $tObj = new WeixinTransfer();
            $res = $tObj->setData($entity)->doTransFer();
            if( !$res['isOk'] )
                throw new Exception("支付信息错误: {$res['msg']}");
            $rObj->status = MgRebateList::CONFIRM;
            $rObj->pay_sn = $res['data'];
            $res = $rObj->save();
        }catch( \Exception $e ){
            $ret = [
                'isOk' =>0,
                'msg' => $e->getMessage()
            ];
            yii::error('审核订单失败:'. $e->getMessage() ); 
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