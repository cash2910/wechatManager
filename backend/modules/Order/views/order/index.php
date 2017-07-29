<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Order Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-order-list-index">
    <p>
        <?= Html::a('创建订单', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'order_sn',
            'user_id',
            'nick_name',
            'mobile',
            'order_num',
            ['label' => '是否支付','value' => function($data){
                return empty( $data->pay_sn ) ? '未支付': '已支付';
            }],
            ['label' => '订单渠道','value' => function($data){
                return \common\models\MgOrderList::$channelDesc[$data->channel];
            }],
            // 'pay_type',
            // 'entity_id',
            // 'pay_sn',
            'add_time',
            // 'update_time',
            [
                'header' => "查看／审核",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete}',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return "";
                      //  return Html::a('查看', ['admin/reviewapp','id'=>$model->id, 'status'=>1], ['class' => "btn btn-xs btn-success"]);
                    },
                    'update' => function ($url, $model, $key) {
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('通过', ['/Order/default/apply-rebate','id'=>$model->id], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('拒绝', ['admin/reviewapp', 'id' => $model->id ], ['class' => "btn btn-xs btn-danger"]);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>