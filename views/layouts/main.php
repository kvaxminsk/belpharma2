<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\widgets\AlertWidget;

/* @var $this \yii\web\View */
/* @var $content string */
$session = Yii::$app->session;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <?php $this->beginBody() ?>
		<!--[if IE>
  <style type="text/css">
   table {
    font-size: 12px !important;  
   }
  </style>
  <![endif]-->
        <div class="wrap">
            <div class="container">
                <div id="header">
                    <a href="http://mail.pharma.by"><img src="/img/logo.png"/></a>
                    <?= $this->render('menuTop') ?>
                    <div id="info">
                        Добрый день, <?= !empty(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : Yii::$app->user->identity->username ?>!<br/>
                        <?php if (Yii::$app->user->identity->role == 2) { ?>
                            Ваш заказ на сумму (руб): <span><?= app\modules\main\models\Orders::getPriceOfOrder() ?> </span>
                        <?php } ?>
                    </div>
                    <div id="out">
                        <a href="/user/default/logout" data-method="post"><img src="/img/out.png"/></a>
                    </div>
                </div>
                <div id="cool">
                    <div class="col-lg-4">
                        <?= $this->render('menuLeft') ?>
                    </div>
                </div>
                <div class="col-lg-8">

                    <?php /*
                      Breadcrumbs::widget([
                      'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                      ]) */
                    ?>
                    <?= AlertWidget::widget() ?>

                    <?= $content ?>

                </div>

            </div>
            <?= isset($this->blocks['modal']) ? $this->blocks['modal'] : '' ?>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; <?= date('Y') ?> <?= Yii::$app->name ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 8 (017) 288-15-77</p>
                <p class="pull-right">Разработали - <a id="reactive" target="_blank" href="http://reactive.by">«Реактивные технологии»</a>
                    <a target="_blank" href="http://reactive.by"><img src="<?= Yii::$app->request->baseUrl ?>/img/reactive.png" alt="Реактивные технологии"/></a></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
