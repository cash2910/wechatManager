<?php
namespace common\components\order;

use yii;
use yii\base\Behavior;
use common\models\MgOrderList;
use common\models\MgUsers;
use common\components\game\Stone;
use common\models\MgGameGoods;
use yii\helpers\ArrayHelper;
/**

 * @param MgOrderList $order_obj
 */
class SendProductBehavior extends Behavior{

    static public $gameSenderMap = [
        4=>'common\components\game\StoneCd',
    ];
    /**
     * 1、先根据uid 查找用户用户的union_id 
     * 2、在从游戏获取union_id对应的用户游戏内id
     * 3、在根据用户游戏内id给用户添加宝石
     * @param MgOrderList $order_obj
     */
    public function sendPackage( MgOrderList $order_obj ){
        try{
            $uInfo = MgUsers::findOne(['id'=>$order_obj->user_id]);
            $gInfo = MgGameGoods::findOne(['id'=>$order_obj->entity_id]);
            if( !$uInfo )
                throw new \Exception("找不到用户 uid:{$order_obj->user_id}");
            $union_id = $uInfo->union_id;
            if( !empty( ArrayHelper::getValue( self::$gameSenderMap , $order_obj->game_id ) ) ){
                $class = new \ReflectionClass( self::$gameSenderMap[$order_obj->game_id] );
                $stoneCom = $class->newInstanceArgs();
            }else{
                $stoneCom = Stone::getInstance();
            }
            $uid = $stoneCom->getUserId( $union_id );
            yii::error( "用户游戏uid:{$uid}");
            $ret = $stoneCom->addStone( $uid, $gInfo->score );
            
        }catch ( \Exception $e ){
            //var_dump( $e->getMessage() );
            yii::error( $e->getMessage() );
        }
    }
}

?>