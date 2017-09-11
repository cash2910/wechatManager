<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameUseropt */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Useropts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-useropt-view">

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
            'union_id',
            'opt_code',
            'game_id',
            'data',
            'ip',
            'add_time',
            'update_time',
        ],
    ]) ?>

</div>
