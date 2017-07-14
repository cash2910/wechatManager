<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MgGames */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-games-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label']
        ]
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'pic_url')->textInput() ?>
    
    <?= $form->field($model, 'url')->textInput() ?>
    
    <?= $form->field($model, 'status')->radioList([0=>'上架',1=>'下架'], ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>
    
    <?php //echo $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
