<?php
namespace common\service\game;

use yii;
use common\service\BaseService;
use common\service\GameInterface;
use common\models\MgGameGoods;
use yii\helpers\ArrayHelper;

class GameService extends BaseService implements GameInterface{
        
    //获取游戏数据
    public function getGames( $cond ){
        
        
        
    }
    
    public function getGameGoods( $gid ){
        $gObjs = MgGameGoods::findAll(['game_id'=>$gid]);
        return ArrayHelper::index($gObjs, 'id');
    }
    
}

?>