<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wechat Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-users-index">
    <p>
        <?= Html::a('初始化微信用户', ['init'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'headimgurl',
                'format'=>'html',
                'label' => '用户头像',
                'value' => function( $model ){
                    return  Html::img($model->headimgurl,[
                        'width'=>40,'height'=>40
                    ]);
                }
            ],
            'open_id',
            'nickname',
            'sex',
           // 'language',
             'city',
             'province',
            // 'country',
            // 'subscribe_time',
            // 'unionid',
            // 'remark',
            // 'tagid_list',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
