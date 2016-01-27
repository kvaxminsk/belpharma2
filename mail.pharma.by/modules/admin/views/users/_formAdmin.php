<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->textInput() ?>

    <?= $form->field($model, 'newPasswordRepeat')->textInput() ?>

    

    <?php // $form->field($model, 'status')->dropDownList($model->getStatusesArray()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'BTN_SAVE') : Yii::t('app', 'BTN_UPDATE'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
