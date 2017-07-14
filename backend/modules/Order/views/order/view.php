<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgOrderList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Order Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-order-list-view">

    <p>
        <?= Html::a('支付订单', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order_sn',
            'user_id',
            'nick_name',
            'mobile',
            'order_num',
            'status',
            'channel',
            'pay_type',
            'entity_id',
            'pay_sn',
            'add_time',
            'update_time',
        ],
    ]) ?>

</div>
