<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wechat Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-menu-index">


    <p>
        <?= Html::a('创建菜单', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('初始化菜单', ['init'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'type',
            'add_time',
            'update_time',
            // 'status',
            // 'content:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
