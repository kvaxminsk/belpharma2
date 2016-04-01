<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\OrderedProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ordered-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kodpart') ?>

    <?= $form->field($model, 'imn') ?>

    <?= $form->field($model, 'otd') ?>

    <?= $form->field($model, 'kolz') ?>

    <?php // echo $form->field($model, 'dsv') ?>

    <?php // echo $form->field($model, 'buggod') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
