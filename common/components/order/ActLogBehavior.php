<?php
namespace common\components\order;

use yii;
use yii\base\Behavior;
use common\models\MgOrderList;
use common\service\order\OrderService;
use common\models\MgUsers;
use common\service\game\StatisticsService;
/**

 * @param MgOrderList $order_obj
 */
class ActLogBehavior extends Behavior{

    public function events()
    {
        return [
            OrderService::AFTER_PAY_ORDER => 'addLog',
        ];
    }
    /**
     * 1、先根据uid 查找用户用户的union_id 
     * 2、在从游戏获取union_id对应的用户游戏内id
     * 3、在根据用户游戏内id给用户添加宝石
     * @param MgOrderList $order_obj
     */
    public function addLog( $event ){
        
        try{
            $orderObj = $event->sender->orderObj;
            $uObj = MgUsers::findOne( ['id'=>$orderObj->user_id] );
            StatisticsService::getInstance()->addActLog( $uObj , StatisticsService::PAY_CODE, [
                'num' => $orderObj->order_num
            ]);
        }catch ( \Exception $e ){
            //var_dump( $e->getMessage() );
            yii::error( $e->getMessage() );
        }
    }
}

?>