<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Rebate Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-rebate-list-index">
    <p style="color:red;font-size:20px;">
        <?php  echo Yii::$app->getSession()->getFlash( 'msg'  ); ?>
    </p>
    <?= Html::beginForm(['rebate/index'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="control-label col-md=5"  >订单号:</label>
            <?php echo Html::input('text','rebate_sn',yii::$app->request->get('rebate_sn',''),['class'=>'form-control','placeholder'=>'请输入订单号'])?>
        </div>         
        <div class="form-group col-md-3">
            <label class="  control-label"  >用户ID:</label>
            <?php echo Html::input('text','user_id',yii::$app->request->get('user_id',''),['class'=>'form-control','placeholder'=>'请输入用户ID'])?>
        </div> 
        <div class="form-group ">
            <label class=" control-label"  for="exampleInputPassword2">申请日期:</label>
            <?php echo Html::input('text','from_date',yii::$app->request->get('from_date',''),['class'=>'form-control','placeholder'=>'开始日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div> 
        <div class="form-group ">
            <?php echo Html::input('text','end_date',yii::$app->request->get('end_date',''),['class'=>'form-control','placeholder'=>'结束日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div>
        <button  type="submit" class="btn btn-success" style="margin-bottom:15px; float:right">搜索</button>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'rebate_sn',
            'user_id',
            ['label' => '是否支付','value' => function($data){
                return \common\models\MgRebateList::$statMsg[$data->status];
            }],
            'desc',
            'pay_sn',
            'rebate_num',
            [
                'label'=>'申请日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'label'=>'更新日期',
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'header' => "查看／审核",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete}',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return Html::a('查看', ['/Order/account-log','user_id'=>$model->user_id], ['class' => "btn btn-xs btn-success"]);
                    },
                    'update' => function ($url, $model, $key) {
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('通过', ['/Order/default/apply-rebate','id'=>$model->id], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('拒绝', ['admin/reviewapp', 'id' => $model->id ], ['class' => "btn btn-xs btn-danger"]);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>
<script src="/js/DatePicker/WdatePicker.js"></script>
<style>
.form-inline .form-group{
	margin-bottom: 15px;
}
</style>