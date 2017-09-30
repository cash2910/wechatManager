<?php
namespace common\service\game;

use yii;
use common\service\BaseService;
use yii\helpers\ArrayHelper;
use common\models\MgUsers;
use common\models\MgUserActlog;
use common\components\game\ActUserBehavior;
use common\models\MgUserRel;

class StatisticsService extends BaseService { 
    
    const PLAY_CODE = '10000';
    const PAY_CODE = '20000';
    static public $msg = [
        self::PLAY_CODE => '8轮对局',
        self::PAY_CODE => '用户充值',
    ];
    
    const AFTER_ADD_LOG  = 'after_add_log';
    
        
    public $log = null; 
    
    public function behaviors(){
        return [
            ActUserBehavior::className()
        ];
    }
    
    public function addActLog( MgUsers $uObj, $code = PLAY_CODE, $data = [] ){
        
        $this->ensureBehaviors();
        $log = new MgUserActlog();
        $log->user_id = $uObj->id;
        $log->open_id = $uObj->open_id;
        $log->union_id = $uObj->union_id;
        $log->opt = $code;
        if( $code == self::PAY_CODE )
            $log->num = ArrayHelper::getValue($data, 'num');
        $log->add_time = time();
        $log->data = json_encode( $data );
        if( !$log->save()) {
            yii::error('活跃信息添加失败'.json_encode( $log->getErrors() ) );
        }
        $this->log = $log;
        $this->trigger(self::AFTER_ADD_LOG);
        
    }
    
    /**
     * 检测用户是否为活跃用户
     * @param MgUsers $uObj
     * @param unknown $date
     */
    public function checkIsActUser( MgUsers $uObj, $date = []){
        
        $isAct = true;
        $info = [];
        $info[self::PLAY_CODE] = 0;
        $info[self::PAY_CODE] = 0;
        $logs = MgUserActlog::find()->where(['open_id'=>$uObj->open_id])->andWhere(['between', 'add_time', strtotime($date['from']),  strtotime($date['to']) ])->all();
        foreach ( $logs as $log ){
            switch ($log->opt){
                case self::PLAY_CODE:
                    $info[self::PLAY_CODE]++;
                    break;
                case self::PAY_CODE:
                    $info[self::PAY_CODE] += $log->num;
                    break;
                default:
                    break;
            }
        }
        print_r($info);
        if( $info[self::PLAY_CODE] < 2 || $info[self::PAY_CODE] == 0 )
                $isAct = false;
        return $isAct;
        
    }
    
    /**
     * 获取某段时间用户所有下级玩家的 活跃用户数
     * @param MgUsers $uObj
     * @param unknown $date
     */
    public  function getActUser( MgUsers $uObj , $date = [] ){
        
        if( empty( $date ) ){
            $date['from'] = '';
            $date['to'] = '';
        }
        
        $users = MgUserRel::findAll(['user_id'=>$uObj->id]);
        if( empty($users) ){
            return [];
        }
        
        $subOpenids = ArrayHelper::getColumn($users, 'sub_user_openid');   
        //获取全部日志
        $users = [];
        $logs = MgUserActlog::find()->where(['open_id'=>$subOpenids])->andWhere(['between', 'add_time', $date['from'],  $date['to']])->all();
        foreach ( $logs as $log ){
            if( !isset( $users[$log->user_id] ) ){
                $users[$log->user_id] = [
                    self::PLAY_CODE => (($log->opt == self::PLAY_CODE ) ? 1: 0 ),
                    self::PAY_CODE => (($log->opt == self::PAY_CODE ) ? $log->num : 0 ),
                ];
            }else{
                switch ($log->opt){
                    case self::PLAY_CODE:
                        $users[$log->user_id][self::PLAY_CODE]++;
                        break;
                    case self::PAY_CODE:
                        $users[$log->user_id][self::PAY_CODE] += $log->num;
                        break;
                    default:
                        break;
                }
            }
        }
        
        //查找满足条件的用户
        foreach ( $users as $uid => &$user ){
            if( $user[self::PLAY_CODE] < 2 || $user[self::PAY_CODE] == 0 )
                unset( $user );
        }
        
        return $users;
        
    }
}

?>