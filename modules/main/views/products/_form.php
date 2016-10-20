<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mnn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kpr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nshort3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'namepr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'otd')->textInput() ?>

    <?= $form->field($model, 'osnls')->textInput() ?>

    <?= $form->field($model, 'tender')->textInput() ?>

    <?= $form->field($model, 'spar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goden_do')->textInput() ?>

    <?= $form->field($model, 'cenopt')->textInput() ?>
    <?= $form->field($model, 'cendogovor')->textInput() ?>

    <?= $form->field($model, 'cenrozn')->textInput() ?>

    <?= $form->field($model, 'kol')->textInput() ?>

    <?= $form->field($model, 'tendergod')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vidtovara')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'obnalichie')->textInput() ?>

    <?= $form->field($model, 'kolotgr')->textInput() ?>

    <?= $form->field($model, 'vidpost')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
