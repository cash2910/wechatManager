<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-users-index">


    <p>
       <!--  <?= Html::a('Create Mg Users', ['create'], ['class' => 'btn btn-success']) ?>  -->
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'headerOptions' => ['style' => 'width: 40px;'],
            ],
            'id',
            'nickname',
            'status',
            'open_id',
            'passwd',
            // 'is_bd',
            // 'mobile',
            // 'register_time',
            // 'update_time',
            // 'user_rels',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
