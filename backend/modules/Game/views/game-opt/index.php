<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Game Useropts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-useropt-index">
    <?= Html::beginForm(['/Game/game-opt'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="control-label col-md=5"  >unionID:</label>
            <?php echo Html::input('text','union_id',yii::$app->request->get('union_id',''),['class'=>'form-control','placeholder'=>'请输入订单号'])?>
        </div>         
        <div class="form-group col-md-3">
            <label class="  control-label"  >Ip:</label>
            <?php echo Html::input('text','ip',yii::$app->request->get('ip',''),['class'=>'form-control','placeholder'=>'请输入用户ID'])?>
        </div> 
        <div class="form-group col-md-6">
            <label class="  control-label"  >操作类型:</label>
            <?php echo Html::dropDownList('opt_code',yii::$app->request->get('opt_code',""),Yii::$app->params['game_opt'],['class'=>'form-control','prompt' => '全部']);?>
        </div> 
        <div class="form-group">
            <label class=" control-label"  for="exampleInputPassword2">操作日期:</label>
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
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'union_id',
            ['label' => '用户','value' => function($data) use ( $uMap ){
                return ArrayHelper::getValue($uMap, $data->union_id);
            }],
            ['label' => '操作类型','value' => function($data){
                return Yii::$app->params['game_opt'][$data->opt_code];
            }],
            //'game_id',
            'data',
             'ip',
            [
                'label'=>'添加日期',
                'attribute' => 'add_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'update_time',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<script src="/js/DatePicker/WdatePicker.js"></script>
<style>
.form-inline .form-group{
	margin-bottom: 15px;
}
</style>