<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WechatUsers */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-users-view">

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
            'open_id',
            'nick_name',
            'sex',
            'language',
            'city',
            'province',
            'country',
            'headimgurl:url',
            'subscribe_time',
            'unionid',
            'remark',
            'tagid_list',
        ],
    ]) ?>

</div>
