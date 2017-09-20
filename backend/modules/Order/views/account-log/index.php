<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\MgUserAccountLog;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg User Account Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-log-index">

    <?= Html::beginForm(['/Order/account-log'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="  control-label"  >用户ID:</label>
            <?php echo Html::input('text','user_id',yii::$app->request->get('user_id',''),['class'=>'form-control','placeholder'=>'请输入用户ID'])?>
        </div> 
        <div class="form-group ">
            <label class=" control-label"  for="exampleInputPassword2">创建日期:</label>
            <?php echo Html::input('text','from_date',yii::$app->request->get('from_date',''),['class'=>'form-control','placeholder'=>'开始日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div> 
        <div class="form-group ">
            <?php echo Html::input('text','end_date',yii::$app->request->get('end_date',''),['class'=>'form-control','placeholder'=>'结束日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div>
        <div class="form-group col-md-3">
            <label class="control-label"  >操作行为:</label>
            <?php echo Html::dropDownList('c_type',yii::$app->request->get('c_type',""),MgUserAccountLog::$msg,['class'=>'form-control','prompt' => '全部']);?>
        </div>
        <button  type="submit" class="btn btn-success" style="margin-bottom:15px; float:right">搜索</button>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'user_id',
            ['label' => '用户昵称','value' => function($data) use ($uMap){
                return ArrayHelper::getValue($uMap, $data->user_id);
            }],
            'num',
            ['label' => '订单渠道','value' => function($data){
                return $data::$msg[$data->c_type];
            }],
            ['label' => '描述','value' => function($data){
                //return preg_replace("/(返利订单：)([0-9]+)/", "订单返利：".Html::a( "\\2", Yii::$app->urlManager->createAbsoluteUrl(['/Order/order/index','order_sn'=> "\\\\2" ] ) , ['target' => '_blank'] ), $data->content);
                preg_match("/(返利订单：)([0-9]+)/", $data->content , $match);
                return isset( $match[2] ) ? $data->content." ".Html::a( "查看订单", Yii::$app->urlManager->createAbsoluteUrl(['/Order/order/index','order_sn'=> $match[2] ] ) , ['target' => '_blank'] ) : $data->content;
            },'format' => 'raw'],
            // 'type',
            [
                'label'=>'添加日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<script src="/js/DatePicker/WdatePicker.js"></script>
<style>
.form-inline .form-group{
	margin-bottom: 15px;
}
</style>