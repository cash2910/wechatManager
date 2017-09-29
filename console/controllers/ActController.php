<?php
namespace console\controllers;

use yii;
use yii\console\Controller;
use common\components\game\ActUserBehavior;
use common\service\game\StatisticsService;
use common\models\MgUsers;
use yii\helpers\ArrayHelper;

/**
 * 计算用户是否活跃
 * @author Administrator
 *
 */
class ActController extends Controller{
    
    const RANK_ZSET_KEY = 'ACT_ZSET_RANK';
    
    /**
     * 微信通知用户
     */
    public function actionCalculateAct(){
        
        do{
            $data = yii::$app->redis->RPOPLPUSH( ActUserBehavior::LIST_KEY , ActUserBehavior::LIST_LOG_KEY);
            if( empty($data) ){
                break;
            }
            $udata = json_decode( $data, true );
            $uObj = MgUsers::findOne(['id'=>ArrayHelper::getValue($udata, 'user_id')]);
            if( !$uObj ){
                continue;
            }
            //获取上级用户
            $pObj = $this->getUserProxy( $uObj );
            if( empty($pObj) )
                continue;
            $_data = yii::$app->redis->HGET( "user_act_list_{$pObj->id}", $uObj->id  );
            //var_dump( $_data ); die('dsadsa');
            if( !empty($_data) )
                continue;
            var_dump( "user_act_list_{$pObj->id}" );
            //判断用户是否满足条件
            $ret = StatisticsService::getInstance()->checkIsActUser( $uObj ,[
               'from'=>'2017-09-01',
               'to' => '2017-11-08'
            ]);
            var_dump( $ret );
            if( $ret ){
                //用户的下级活跃数增加
                yii::$app->redis->hset( "user_act_list_{$pObj->id}", $uObj->id, json_encode( $uObj->getAttributes() )  );
                yii::$app->redis->zincrby( self::RANK_ZSET_KEY , 1, "user_act_users_{$pObj->id}"  );
            }
                
        }while(true);
    }
  
    private function getUserProxy( MgUsers $uObj ){
        
        $pObj = null;
        if( !empty( $uObj->user_rels ) ){
            $uids = explode( '-' , $uObj->user_rels);
            $pid = array_pop($uids);
            $pObj = MgUsers::findOne(['id'=>$pid]);
        }
        return $pObj;
    }
    
}

?>