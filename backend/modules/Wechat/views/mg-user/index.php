<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\MgUsers;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mg Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-users-index">
     <?= Html::beginForm(['/Wechat/mg-user'], 'get', ['enctype' => 'multipart/form-data','class'=>'form-inline']) ?>
        <div class="form-group col-md-3">
            <label class="control-label col-md=5"  >用户昵称:</label>
            <?php echo Html::input('text','nickname',yii::$app->request->get('nickname',''),['class'=>'form-control','placeholder'=>'用户昵称'])?>
        </div>         
        <div class="form-group col-md-3">
            <label class="  control-label"  >用户ID:</label>
            <?php echo Html::input('text','user_id',yii::$app->request->get('user_id',''),['class'=>'form-control','placeholder'=>'请输入用户ID'])?>
        </div> 
        <div class="form-group col-md-3">
            <label class=" control-label"  >用户openid:</label>
            <?php echo Html::input('text','open_id',yii::$app->request->get('open_id',''),['class'=>'form-control','placeholder'=>'open_id...'])?>
        </div>
        <div class="form-group col-md-3">
            <label class=" control-label"  >用户unionid:</label>
            <?php echo Html::input('text','union_id',yii::$app->request->get('union_id',''),['class'=>'form-control','placeholder'=>'union_id...'])?>
        </div>
        <div class="form-group col-md-3">
            <label class="control-label"  >是否关注:</label>
            <?php echo Html::dropDownList('status',yii::$app->request->get('status',""),MgUsers::$status_msg,['class'=>'form-control','prompt' => '全部']);?>
        </div>
        <button  type="submit" class="btn btn-success" style="margin-bottom:15px; float:right">搜索</button>
    <?= Html::endForm() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'id',
                'headerOptions' => ['style' => 'width: 40px;'],
            ],  
            [
                'attribute' => 'user_logo',
                'headerOptions' => ['style' => 'width: 80px;'],
                'format'=>'html',
                'label' => '用户头像',
                'value' => function( $model ){
                    return  Html::img($model->user_logo,[
                        'width'=>40,'height'=>40
                    ]);
                }
            ],
            'nickname',
            ['label' => '订单渠道','value' => function($data){
                return $data::$status_msg[$data->status];
            }],
            'open_id',
            'union_id',
            //'passwd',
            // 'is_bd',
            // 'mobile',
            [
            'label'=>'申请日期',
            'attribute' => 'register_time',
            'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'update_time',
            'user_rels',
            [
                'header' => "查看详情",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {view1} {view2}',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                         return Html::a('查看', ['/Wechat/mg-user/view','id'=>$model->id], ['class' => "btn btn-xs btn-success"]);
                    },
                    'view1' => function ($url, $model, $key) {
                         $rel = !empty( $model->user_rels ) ? $model->user_rels.'-'.$model->id : $model->id;
                         return Html::a('推广信息', ['/Wechat/mg-user/','fri'=>$rel ], ['class' => "btn btn-xs btn-info"]);
                    },
                    'view2' => function ($url, $model, $key) {
                        return Html::a('查看账户', ['/Order/profit','user_id'=>$model->id], ['class' => "btn btn-xs btn-success",'target'=>'_blank']);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>
<style>
.form-inline .form-group{
	margin-bottom: 15px;
}
</style>