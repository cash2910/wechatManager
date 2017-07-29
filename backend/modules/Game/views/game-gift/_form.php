<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MgGames;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\MgGameGift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-game-gift-form">

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

    <?= $form->field($model, 'game_id')->dropDownList( $gameMap, ['prompt' => '请选择游戏'] ) ?>
     
    <?= $form->field($model, 'game_uid')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'num')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apply_user')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
