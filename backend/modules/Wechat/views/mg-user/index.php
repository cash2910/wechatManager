<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-users-index">


    <p>
       <!--  <?= Html::a('Create Mg Users', ['create'], ['class' => 'btn btn-success']) ?>  -->
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'headerOptions' => ['style' => 'width: 40px;'],
            ],
            'id',
            'nickname',
            'status',
            'open_id',
            //'passwd',
            // 'is_bd',
            // 'mobile',
            [
            'label'=>'申请日期',
            'attribute' => 'register_time',
            'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'update_time',
            'user_rels',
            [
                'header' => "查看详情",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view}',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return Html::a('查看', ['/Wechat/mg-user/view','id'=>$model->id], ['class' => "btn btn-xs btn-success"]);
                    },
/*                     'update' => function ($url, $model, $key) {
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('通过', ['/Order/default/apply-rebate','id'=>$model->id], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('拒绝', ['admin/reviewapp', 'id' => $model->id ], ['class' => "btn btn-xs btn-danger"]);
                    } */
                 ]
            ]
        ],
    ]); ?>
</div>
