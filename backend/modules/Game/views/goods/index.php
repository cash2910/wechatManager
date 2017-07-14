<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\MgGames;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Game Goods';
$this->params['breadcrumbs'][] = $this->title;

$games = MgGames::find()->all();
$gameMap =ArrayHelper::map($games,'id','title'); 
?>
<div class="mg-game-goods-index">

    <p>
        <?= Html::a('新增商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            ['label' => '游戏','value' => function($data)  use ($gameMap) {
                return $gameMap[$data->game_id];
            }],
            'title',
            'price',
             ['label' => '是否在售','value' => function($data){
                return \common\models\MgGameGoods::$statDesc[$data->status];
            }],
            // 'type',
            // 'content',
            // 'add_time',
            // 'update_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
