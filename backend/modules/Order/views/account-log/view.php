<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgUserAccountLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg User Account Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'user_id',
            'num',
            'c_type',
            'content',
            'type',
            'add_time',
        ],
    ]) ?>

</div>
