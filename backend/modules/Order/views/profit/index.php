<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户余额信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-index">
    <p>
        <?php // echo Html::a('Create Mg User Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user_id',
            'balance',
            'free_balance',
            'update_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
