<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MgUsers;

/* @var $this yii\web\View */
/* @var $model common\models\MgUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-users-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label']
        ]
    ]); ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(MgUsers::$status_msg, ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>
    
    <?= $form->field($model, 'open_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passwd')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_bd')->radioList( MgUsers::$role_msg, ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'register_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_rels')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'user_proxy_rels')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'rebate_ratio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
