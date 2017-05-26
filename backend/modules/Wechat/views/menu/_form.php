<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WechatMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-menu-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label']
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->radioList([1=>'默认菜单',2=>'自定义菜单'], ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>
    
    <?= $form->field($model, 'status')->radioList([0=>'未启用',1=>'已启用'], ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>

    <?php //echo $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group field">
        <div class="col-xs-3 col-sm-2 text-right">
            <label class="control-label" for="eqesc">菜单设置</label>
        </div>
        <div class="col-xs-9 col-sm-10">
            <div class="col-xs-12 col-sm-12">
                <div class="col-lg-2" style="width: 110px; padding: 0px 10px 0px 0px;"> 
                </div>
                <div class="col-lg-2" style="width: 100px; padding: 0px 10px 0px 0px;"> 
                </div>
                 <div class="col-lg-2" style="width: 110px; padding: 0px 10px 0px 0px;"> 
                </div>
                <div class="col-lg-2" style="width: 100px; padding: 0px;">
                </div>
            </div>
        </div>
   </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJsFile('/js/DatePicker/WdatePicker.js'); ?>