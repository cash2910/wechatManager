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
    

    <?= $form->field($model, 'add_time')->textInput(['onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss"})']) ?>

    <?= $form->field($model, 'update_time')->textInput(['onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss"})']) ?>
    
    <?= $form->field($model, 'status')->radioList([0=>'未启用',1=>'已启用'], ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->registerJsFile('/js/DatePicker/WdatePicker.js'); ?>