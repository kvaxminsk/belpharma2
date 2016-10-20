<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->textInput() ?>
    
    <?= $form->field($model, 'newPasswordRepeat')->textInput() ?>
    
    <?= $form->field($model, 'name')->textInput() ?>
    
    <?= $form->field($model, 'address')->textInput() ?>

    <?= $form->field($model, 'group')->dropDownList(['0'=>'Для ЛПУ','1' => 'Договорная']) ?>

    <?= $form->field($model, 'phone')->textInput() ?>
    
    <?= $form->field($model, 'cod')->textInput() ?>
    
    <?= $form->field($model, 'responsible_person')->textInput() ?>
    
    <?php // $form->field($model, 'status')->dropDownList($model->getStatusesArray()) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'BTN_SAVE') : Yii::t('app', 'BTN_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
