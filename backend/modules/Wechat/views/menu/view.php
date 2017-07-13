<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WechatMenu */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-menu-view">

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
            'type',
            'add_time',
            'update_time',
            'status',
            'content:ntext',
        ],
    ]) ?>

</div>
