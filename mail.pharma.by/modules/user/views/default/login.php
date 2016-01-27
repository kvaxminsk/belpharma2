<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\user\models\LoginForm */

$this->title = Yii::t('app', 'USER_LOGIN');
?>

    <div id="pharm-info">
        <p class="text-uppercase huge"><span class="regular">РУП</span><br/>«БЕЛФАРМАЦИЯ»</p>
        <div class="white-line"></div>
        <p class="text-uppercase">Государственная<br/>аптечная сеть<br/>Республики Беларусь</p>
        <div class="white-line"></div>
        <p class="regular" id="contacts">220005, г.Минск, ул.В.Хоружей,11<br/>
            Телефон: 288-15-77<br/>
            Факс: 288-25-26 </p>
    </div>
    <div id="form">
        <a id="enter" href="/">Вход</a>
        
        <p id="form-name">Личный Кабинет</p>
        <?php $form = ActiveForm::begin(['id' => 'log-in']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox(['labelOptions' => ['class' => 'label-checkbox']]) ?>
            
            <div class="clearfix"></div>
            <?= Html::submitButton(Yii::t('app', 'USER_LOGIN'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Yii::t('app', 'USER_LOGIN_IFRESET') ?> <?= Html::a(Yii::t('app', 'USER_LOGIN_RESETIT'), ['/request-password-reset'], ['id' => 'forgot']) ?>
            <a class="dotted bottom" id="return" href="http://pharma.by"><img src="img/arrow.png" alt=""/>На сайт</a>
        <?php ActiveForm::end(); ?>
    </div>