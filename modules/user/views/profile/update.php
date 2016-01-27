<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

    $this->title = Yii::t('app', 'USER_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'USER_PROFILE_TITLE'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'email') ?>
<?= Html::submitInput(Yii::t('app', 'BTN_SAVE'), ['class' => 'btn btn-success']) ?>
<?php ActiveForm::end() ?>