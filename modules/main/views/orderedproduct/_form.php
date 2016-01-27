<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\OrderedProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ordered-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kolz')->textInput() ?>

    <?php // $form->field($model, 'dsv')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
