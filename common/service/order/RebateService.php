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
use common\models\MgUserAccountLog;
use common\service\weixin\WeChatService;

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
        if( $num <= 5 ){
            $ret['msg'] = "提现金额必须大于5元";
            return $ret;
        }
        //手续费
        $fee = 0;
        $rule = [
            ['range'=>[0,200],'fee'=>5],
            ['range'=>[200,9999999],'fee'=>0]
        ];
        foreach ( $rule as $r ){
            $min = $r['range'][0]; $max = $r['range'][1];
            if( $num >= $min && $num < $max ){
                $fee = $r['fee'];
                break;
            }
        }
        if( ($num + $fee) > $account->free_balance ){
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
            $rebateObj->fee = $fee;
            if( $fee > 0 ){
                $rebateObj->desc .= " 手续费¥{$fee}";
            }
            $rebateObj->rebate_num = ($num - $fee);
            $res = $rebateObj->save();
            if( !$res )
                throw new \Exception( json_encode( $rebateObj->getErrors() ) );
            $account->free_balance -= ($num+$fee);
            $res = $account->save();
            if( !$res )
                throw new \Exception( json_encode( $rebateObj->getErrors() ) );
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
                'spbill_create_ip'=>  yii::$app->request->userIP,
            ]);
            $tObj = new WeixinTransfer();
            $res = $tObj->setData($entity)->doTransFer();
            if( !$res['isOk'] )
                throw new Exception("支付信息错误: {$res['msg']}");
            $rObj->status = MgRebateList::CONFIRM;
            $rObj->pay_sn = $res['data'];
            $res = $rObj->save();
            //添加提现记录
            $rebateRecord = new MgUserAccountLog();
            $rebateRecord->user_id = $uInfo->id;
            $rebateRecord->num = $rObj->rebate_num ;
            $rebateRecord->c_type = MgUserAccountLog::OUTCOME;
            $rebateRecord->content = "提现：{$rObj->rebate_num} 元";
            $rebateRecord->add_time = date('Y-m-d H:i:s');
            $rebateRecord->save();
            //提现通知
            $res = WeChatService::getIns()->sendCsMsg([
                'touser'=> $uInfo->open_id,
                'msgtype'=>'text',
                'text'=>[
                    'content'=> "您成功提现 {$rObj->rebate_num} 元！~"
                ]
            ]);
            yii::error( json_encode( $res ) );
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