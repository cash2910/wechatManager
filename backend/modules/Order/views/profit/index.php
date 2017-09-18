<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户余额信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-index">
    <?= Html::beginForm(['/Order/profit'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="  control-label"  >用户ID:</label>
            <?php echo Html::input('text','user_id',yii::$app->request->get('user_id',''),['class'=>'form-control','placeholder'=>'请输入用户ID'])?>
        </div> 
        <button  type="submit" class="btn btn-success" style="margin-bottom:15px; float:right">搜索</button>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user_id',
            'balance',
            'free_balance',
            'total_balance',
            'total_num',
            'update_time',
            [
                'header' => "查看详情",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} ',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return Html::a('查看历史记录', ['/Order/account-log','user_id'=>$model->user_id], ['class' => "btn btn-xs btn-success"]);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>
