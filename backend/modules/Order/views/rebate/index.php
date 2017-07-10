<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Rebate Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-rebate-list-index">


    <p>
        <?php //echo Html::a('Create Mg Rebate List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'rebate_sn',
            'user_id',
            'status',
            'desc',
            // 'rebate_num',
            // 'add_time',
            // 'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
