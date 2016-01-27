<?php

use app\assets\LoginAsset;
use yii\helpers\Html;
/* @var $this yii\web\View */
LoginAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head(); ?>
</head>
<body class="main-page">
<?php $this->beginBody(); ?>
    <div id="container">
        <div id="header">
            <a href="/">
                <img src="img/logotype.png" alt="Белфармация"/>
                <div id="logo-content">
                    <span id="title-name">Белфармация</span>
                    <span class="regular">Рядом с Вами</span>
                </div>
            </a>
        </div>
        <div id="content"><?= $content ?></div>
        <div id="footer">
            <div id="reloading">
            <div class="footer-el">
                <a href="http://pharma.by/search_drugs/"><img src="img/spravka.png" alt="Аптечное справочное бюро"/><p>Аптечное<br/>справочное бюро</p></a><br/>
            </div>
            <div class="footer-el">
                <a href="http://pharma.by/round-the-clock/"><img src="img/24hour.png" alt="Круглосуточные аптеки"/><p>Круглосуточные<br/>аптеки</p></a><br/>
            </div>
            <div class="footer-el">
                <a href="http://pharma.by/producer/"><img src="img/belarus.png" alt="Отечественные производители"/><p class="last-el">Отечественные<br/>производители</p></a>
            </div>
            </div>
        </div>
        <div id="footer-info">
            <div class="regular" id="footer-info-content">
                <span>&copy; 2015 РУП «Белфармация»</span>
                <span>8 (017) 288-15-77</span>
                <span class="last">Разработали - <a id="reactive" target="_blank" href="http://reactive.by">«Реактивные технологии»</a>
                <a target="_blank" href="http://reactive.by"><img src="img/reactive.png" alt="Реактивные технологии"/></a></span>
            </div>
        </div>
    </div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>