<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgRebateList */

$this->title = $model->rebate_sn;
$this->params['breadcrumbs'][] = ['label' => 'Mg Rebate Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-rebate-list-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rebate_sn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rebate_sn], [
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
            'rebate_sn',
            'user_id',
            'status',
            'desc',
            'rebate_num',
            'add_time',
            'update_time',
        ],
    ]) ?>

</div>
