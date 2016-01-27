<?php

/* @var $this yii\web\View */
/* @var $fptHost app\modules\admin\models\Settings */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$options = ['class' => 'btn btn-primary'];
$this->params['menu'] = 9;
?>
<h1>Настройки веб-приложения (Адрес ftp-сервера, данные для доступа к ftp)</h1>


<div class="panel panel-default">
    <div class="panel-heading">Адрес ftp-сервера</div>
    <div class="panel-body">
        <?php $form1 = ActiveForm::begin(['action' => ['save', 'key' => 'ftp-host']]); ?>
        <?= $form1->field($ftpHost, 'value')->label('') ?>
        <?= Html::submitButton('Сохранить', $options) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Логин</div>
    <div class="panel-body">
        <?php $form2 = ActiveForm::begin(['action' => ['save', 'key' => 'ftp-login']]); ?>
        <?= $form2->field($ftpLogin, 'value')->label('') ?>
        <?= Html::submitButton('Сохранить', $options) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Пароль</div>
    <div class="panel-body">
        <?php $form3 = ActiveForm::begin(['action' => ['save', 'key' => 'ftp-password']]); ?>
        <?= $form3->field($ftpPassword, 'value')->label('') ?>
        <?= Html::submitButton('Сохранить', $options) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Папка для отправки заказов</div>
    <div class="panel-body">
        <?php $form4 = ActiveForm::begin(['action' => ['save', 'key' => 'ftp-folder-in']]); ?>
        <?= $form4->field($ftpIn, 'value')->label('Введите только наименование папки, без слэшей.') ?>
        <?= Html::submitButton('Сохранить', $options) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Папка с накладными</div>
    <div class="panel-body">
        <?php $form5 = ActiveForm::begin(['action' => ['save', 'key' => 'ftp-folder-out']]); ?>
        <?= $form5->field($ftpOut, 'value')->label('Введите только наименование папки, без слэшей.') ?>
        <?= Html::submitButton('Сохранить', $options) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>

