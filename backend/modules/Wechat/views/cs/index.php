<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wechat Cs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-cs-index">


    <p>
        <?= Html::a('添加客服', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kf_account',
            'kf_nick',
            'kf_id',
            'kf_headimgurl:url',
            // 'kf_wx',
            // 'invite_wx',
            // 'invite_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
