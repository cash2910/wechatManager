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
            // 'order_num',
            ['label' => '是否支付','value' => function($data){
                return empty( $data->pay_sn ) ? '未支付': '已支付';
            }],
            ['label' => '订单渠道','value' => function($data){
                return \common\models\MgOrderList::$channelDesc[$data->channel];
            }],
            // 'pay_type',
            // 'entity_id',
            // 'pay_sn',
            // 'add_time',
            // 'update_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>