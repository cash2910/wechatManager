<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WechatMessage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wechat-message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'open_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_tie')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
