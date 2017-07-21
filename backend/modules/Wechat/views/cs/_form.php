<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WechatCs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-cs-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label']
        ]
    ]); ?>

    <?= $form->field($model, 'kf_account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kf_nick')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kf_id')->textInput() ?>

    <?= $form->field($model, 'kf_headimgurl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kf_wx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invite_wx')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invite_status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
