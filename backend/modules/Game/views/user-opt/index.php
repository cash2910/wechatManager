<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg User Actlogs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-actlog-index">
    <?= Html::beginForm(['/Game/user-opt/index'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="control-label col-md=5"  >用户ID:</label>
            <?php echo Html::input('text','user_id',yii::$app->request->get('user_id',''),['class'=>'form-control','placeholder'=>'用户id号'])?>
        </div>
        <div class="form-group col-md-6">
            <label class="  control-label"  >操作类型:</label>
            <?php echo Html::dropDownList('opt',yii::$app->request->get('opt',""),common\service\game\StatisticsService::$msg,['class'=>'form-control','prompt' => '全部']);?>
        </div> 
       <div class="form-group ">
            <label class=" control-label"  for="exampleInputPassword2">日期:</label>
            <?php echo Html::input('text','from_date',yii::$app->request->get('from_date',''),['class'=>'form-control','placeholder'=>'开始日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div> 
        <div class="form-group ">
            <?php echo Html::input('text','end_date',yii::$app->request->get('end_date',''),['class'=>'form-control','placeholder'=>'结束日期','readonly'=>'true','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})"])?>
        </div>
        
        <button  type="submit" class="btn btn-success" style="margin-bottom:15px; float:right">搜索</button>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' =>'{items}<div class="text-right tooltip-demo">{summary}   {pager}</div>',
        'columns' => [
            'id',
            'union_id',
            ['label' => '用户昵称','value' => function($data) use ($uMap){
                return $uMap[$data->user_id];
            }],
            'user_id',
            ['label' => '用户操作','value' => function($data) use ($uMap){
                return ArrayHelper::getValue( common\service\game\StatisticsService::$msg, $data->opt);
            }],
            // 'num',
             'data',
             [
                'label'=>'申请日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<script src="/js/DatePicker/WdatePicker.js"></script>