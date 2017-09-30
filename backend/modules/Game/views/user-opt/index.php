<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg User Actlogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-actlog-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'union_id',
            'user_id',
            'open_id',
            'opt',
            // 'num',
             'data',
             'add_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
