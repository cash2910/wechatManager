<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameUseropt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-game-useropt-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'union_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opt_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'game_id')->textInput() ?>

    <?= $form->field($model, 'data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'add_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
