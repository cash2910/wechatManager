<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg User Account Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-log-index">

    <p>
        <?= Html::a('确定', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'num',
            ['label' => '订单渠道','value' => function($data){
                return $data::$msg[$data->c_type];
            }],
            'content',
            // 'type',
            [
                'label'=>'添加日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
