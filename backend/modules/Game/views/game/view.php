<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgGames */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Mg Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-games-view">

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
            'title',
            'desc',
            'status',
            'type',
            'add_time',
            'update_time',
            'remark',
        ],
    ]) ?>

</div>
