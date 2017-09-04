<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wechat Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-message-index">
    <p>
        <?= Html::a('新增消息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'status',
            'content',
            'open_id',
            // 'num',
            // 'add_time',
            // 'update_tie',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
