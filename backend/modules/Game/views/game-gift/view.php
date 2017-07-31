<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameGift */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-gift-view">

    <p>
     <!--    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
         -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'game_id',
            'game_uid',
            'data',
            'status',
            'desc',
            'game_sn',
            'apply_user',
            [
                'label'=>'申请日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'label'=>'申请日期',
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ]
        ],
    ]) ?>

</div>
