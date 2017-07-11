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
            'id',
            'rebate_sn',
            'user_id',
            ['label' => '是否支付','value' => function($data){
                return \common\models\MgRebateList::$statMsg[$data->status];
            }],
            'desc',
            'rebate_num',
            [
                'label'=>'申请日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'update_time',
            [
                'header' => "查看／审核",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete}',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => "glyphicon fa fa-eye"]), ['admin/view-app', 'id'=>$model->id], ['class' => "btn btn-xs btn-success", 'title' => '查看']);
                    },
                    'update' => function ($url, $model, $key) {
                          return Html::a('通过', ['admin/reviewapp','id'=>$model->id, 'status'=>1], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                            return Html::a('拒绝', ['admin/reviewapp', 'id' => $model->id, 'status'=>0], ['class' => "btn btn-xs btn-danger"]);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>
