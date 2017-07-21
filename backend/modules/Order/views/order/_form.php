<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\MgGames;

/* @var $this yii\web\View */
/* @var $model common\models\MgOrderList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-order-list-form">

    <?php 
        $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
                'labelOptions' => ['class' => 'col-sm-2 control-label']
            ]
        ]); 
        $games = MgGames::find()->all();
        $gameMap =ArrayHelper::map($games,'id','title');
    ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'game_id')->dropDownList( $gameMap, ['prompt' => '请选择游戏'] ) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entity_id')->textInput() ?>


    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
