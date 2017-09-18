<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wechat Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-message-index">
    <p>
        <?= Html::a('新增消息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['label' => '类型','value' => function($data){
                return $data::$type_msg[$data->type];
            }],
            ['label' => '状态','value' => function($data){
                return $data::$status_msg[$data->status];
            }],
            ['label' => '内容','value' => function($data){
                return common\helper\StringHelp::truncateUtf8String( $data->content ,10);
            }],
            'open_id',
             'num',
            'add_time:datetime',
            // 'update_tie',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
