<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Order Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-order-list-index">
    <?= Html::beginForm(['order/index'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="control-label col-md=5"  >订单号:</label>
            <?php echo Html::input('text','order_sn',yii::$app->request->get('order_sn',''),['class'=>'form-control','placeholder'=>'请输入订单号'])?>
        </div>         
        <div class="form-group col-md-3">
            <label class="  control-label"  >用户昵称:</label>
            <?php echo Html::input('text','nick_name',yii::$app->request->get('nick_name',''),['class'=>'form-control','placeholder'=>'请输入用户昵称'])?>
        </div> 
        <div class="form-group col-md-3">
            <label class="  control-label"  >用户ID:</label>
            <?php echo Html::input('text','user_id',yii::$app->request->get('user_id',''),['class'=>'form-control','placeholder'=>'请输入用户ID'])?>
        </div> 
        <div class="form-group col-md-3">
            <label class="control-label"  >是否支付:</label>
            <?php echo Html::dropDownList('p_status',yii::$app->request->get('p_status',""),[1=>"已支付",2=>'未支付'],['class'=>'form-control','prompt' => '全部']);?>
        </div>
        <div class="form-group ">
            <label class=" control-label"  for="exampleInputPassword2">创建日期:</label>
            <?php echo Html::input('text','from_date',yii::$app->request->get('from_date',''),['class'=>'form-control','placeholder'=>'开始日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div> 
        <div class="form-group ">
            <?php echo Html::input('text','end_date',yii::$app->request->get('end_date',''),['class'=>'form-control','placeholder'=>'结束日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div>
        <?= Html::a("导出", Url::current(['export'=>1]), ["class" => "btn btn-info","style"=>'margin-bottom:15px;  float:right',"target"=>'blank']) ?>
        <button  type="submit" class="btn btn-success" style="margin-bottom:15px;  margin-right:5px; float:right">搜索</button>
        
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'order_sn',
            'user_id',
            'nick_name',
            'mobile',
            'order_num',
            ['label' => '是否支付','value' => function($data){
                return empty( $data->pay_sn ) ? '未支付': '已支付';
            }],
            ['label' => '订单渠道','value' => function($data){
                return \common\models\MgOrderList::$channelDesc[$data->channel];
            }],
            // 'pay_type',
            // 'entity_id',
            // 'pay_sn',
            'add_time',
            // 'update_time',
            [
                'header' => "查看／审核",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete}',
                //'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return Html::a('查看', ['/Order/order/view','id'=>$model->id], ['class' => "btn btn-xs btn-success"]);
                    },
                    'update' => function ($url, $model, $key) {
                          return "";
                          if( $model->status == common\models\MgRebateList::APPLY  )
                                return Html::a('通过', ['/Order/default/apply-rebate','id'=>$model->id], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                          return "";
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