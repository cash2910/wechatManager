<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MgGames;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameGoods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-game-goods-form">

    <?php $form = ActiveForm::begin([
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'score')->textInput(['maxlength' => true,]) ?>

    <?= $form->field($model, 'status')->radioList([1=>'上架',2=>'下架'], ['itemOptions' => ['labelOptions' => ['class' => 'radio-inline']]]) ?>

    <?php //$form->field($model, 'type')->textInput() ?>

    <?php // $form->field($model, 'content')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
