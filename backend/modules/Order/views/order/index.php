<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Order Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-order-list-index">
    <form class="form-inline" style="padding-bottom: 20px;">
         <div class="form-group">
            <label class="sr-only" for="exampleInputEmail2">邮箱</label>
            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="请输入你的邮箱地址">
        </div>
        <div class="form-group" >
            <label class="sr-only" for="exampleInputPassword2">密码</label>
            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="请输入你的邮箱密码">
        </div>
        <div class="form-group" >
            <label class="sr-only" for="exampleInputPassword2">密码</label>
            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="请输入你的邮箱密码">
        </div>
        <div class="checkbox">
            <label >
                <input type="checkbox" >记住密码
            </label>
        </div>
        <button type="submit" class="btn btn-default">进入邮箱</button>
    </form>
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
                //'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return Html::a('查看', ['/Order/order/view','id'=>$model->id], ['class' => "btn btn-xs btn-success"]);
                    },
                    'update' => function ($url, $model, $key) {
                          return "";
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('通过', ['/Order/default/apply-rebate','id'=>$model->id], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                          return "";
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('拒绝', ['admin/reviewapp', 'id' => $model->id ], ['class' => "btn btn-xs btn-danger"]);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>