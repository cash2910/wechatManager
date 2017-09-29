<?php
namespace common\components\game;

use yii;
use yii\base\Behavior;
use common\models\MgOrderList;
use common\models\MgUsers;
use common\service\game\StatisticsService;
use yii\base\Event;
/**

 * @param MgOrderList $order_obj
 */
class ActUserBehavior extends Behavior{

    const LIST_KEY = 'ACT_USER_LISTS';
    const LIST_LOG_KEY = 'ACT_USER_LISTS_BAK';
    public function events()
    {
        return [
            StatisticsService::AFTER_ADD_LOG => 'addActList',
        ];
    }
    /**
     * 计算用户活跃
     * 根据当前活动时间范围内满足条件的下级用户视为活跃用户
     */
    public function addActList( Event $event ){
        try{
            $logObj = $event->sender->log;
            yii::$app->redis->lpush( self::LIST_KEY, json_encode( $logObj->getAttributes() ) );
        }catch ( \Exception $e ){
            //var_dump( $e->getMessage() );
            yii::error( $e->getMessage() );
        }
    }
}

?>