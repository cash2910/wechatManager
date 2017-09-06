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
class RebateBehavior extends Behavior{

    //默认返利用户
    const DEFAULT_UID = 322;
    /**
     * 订单金额小于1元不进行返利
     * 1、获取返利用户
     * 2、创建返利单 并将返利添加入用户账户
     * 先获取底层代理的返利
     * @param MgOrderList $order_obj
     */
    public function doBalance( MgOrderList $order_obj ){
        
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $uInfo = MgUsers::findOne([ 'id'=>$order_obj->user_id ]);
            $total = $order_obj->order_num;
            $defaultUid = yii::$app->params['DEFAULT_USER'];
            if( empty($uInfo->user_rels) ){
                //不存在上级则划入公司账户
                $data[$defaultUid] =  ['uid'=> $defaultUid, 'refund'=> $order_obj->order_num, 'ratio'=>100 ,'total'=>$order_obj->order_num ]; 
            }else{
                $uids =  explode( "-", $uInfo->user_rels );
                //直接代理
                $proxyId =  array_pop( $uids );
                //间接代理
                $pObj = MgUsers::findOne(['id'=>$proxyId]);
                $superProxyIds  = [];
                $userArr = [];
                if( !empty( $pObj->user_proxy_rels ) ){
                    $superProxyIds = explode( "-",  $pObj->user_proxy_rels );
                    $userArr = MgUsers::findAll(['id'=>$superProxyIds]);
                }
                array_push( $userArr, $pObj );
                $userArr = array_reverse( $userArr );
                $data = []; $devided_ratio = 0;
                foreach ( $userArr as $uObj ){
                    $cur_ratio = ( $uObj->rebate_ratio - $devided_ratio );
                    $_refund = $cur_ratio*$total/100;
                    $data[$uObj->id] = ['uid'=> $uObj->id, 'refund'=> $_refund, 'ratio'=>$cur_ratio ,'total'=>$total ];       
                    $devided_ratio = $uObj->rebate_ratio;
                }
                //公司分成
                $company_ratio = 100 -$devided_ratio ;
                $company_refund = $company_ratio*$total/100;
                $data[$defaultUid] = ['uid'=> $defaultUid, 'refund'=> $company_refund, 'ratio'=>$company_ratio ,'total'=>$total ];
            }
            $ret = $this->genRefund( $data, $order_obj , $uInfo );
            $transaction->commit();
        }catch ( \Exception $e ){
            
            $transaction->rollBack();
            yii::error( "订单{$order_obj->order_sn}返利失败： ".$e->getMessage() );
        }
        var_dump($ret);
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
                $u->total_balance = $d['refund'];
                $u->total_num = $d['total'];
            }else{
                $u->free_balance += $d['refund'];
                $u->total_balance += $d['refund'];
                $u->total_num += $d['total'];
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
        return $ret;
    }
    
    
    private function getDefaultUser(){
        $uid = yii::$app->params['DEFAULT_USER'];
        return MgUsers::findOne( ['id'=>$uid] );
    }
}

?>
