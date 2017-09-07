<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-users-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'nickname',
            'status',
            'open_id',
            'union_id',
            'passwd',
            'is_bd',
            'mobile',
            [
                'label'=>'申请日期',
                'attribute' => 'register_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],[
            'label'=>'更新日期',
            'attribute' => 'update_time',
            'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            'user_rels',
            'user_proxy_rels',
            'rebate_ratio'
        ],
    ]) ?>

</div>
