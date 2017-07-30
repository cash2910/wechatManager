<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Game Gifts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-gift-index">
    <p>
        <?= Html::a('赠送道具', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'game_id',
            'game_uid',
            'num',
            ['label' => '状态','value' => function($data){
                return $data::$msg[$data->status];
            }],
            //'data',
            'desc',
            'game_sn',
            // 'apply_user',
            'add_time:datetime',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
