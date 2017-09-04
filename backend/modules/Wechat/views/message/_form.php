<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\WechatMessage;

/* @var $this yii\web\View */
/* @var $model common\models\WechatMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-message-form">

      <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label']
        ]
    ]); ?>

    <?= $form->field($model, 'type')->radioList(WechatMessage::$type_msg, ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']],'value'=>WechatMessage::TYPE_ALL]) ?>

    <?= $form->field($model, 'status')->radioList(WechatMessage::$status_msg, ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']],'value'=>WechatMessage::STATUS_WAIT]) ?>
    
    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'open_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num')->textInput(['maxlength' => true]) ?>
 

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
