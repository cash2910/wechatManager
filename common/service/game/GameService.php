<?php
namespace common\service\game;

use yii;
use common\service\BaseService;
use common\service\GameInterface;
use common\models\MgGameGoods;
use yii\helpers\ArrayHelper;

class GameService extends BaseService implements GameInterface{
        
    const ROOM_KEY = 'GAME_ROOM_INFOS';
    //获取游戏数据
    public function getGames( $cond ){
        
        
        
    }
    
    public function getGameGoods( $gid ){
        $gObjs = MgGameGoods::findAll(['game_id'=>$gid]);
        return ArrayHelper::index($gObjs, 'id');
    }
    
    /**
     * 记录8局的房间信息到redis
     */
    public function addRoom( $data ){
         $info = json_encode( $data );
         yii::$app->redis->hset( static::ROOM_KEY, ArrayHelper::getValue($data, 'room_id' ),  $info);
    }
    
    /**
     * 获取房间信息
     * @param unknown $room_id
     */
    public function getRoom( $room_id ){
        return json_decode( yii::$app->redis->hget( static::ROOM_KEY , $room_id ) ,true );
    }
    
}

?>