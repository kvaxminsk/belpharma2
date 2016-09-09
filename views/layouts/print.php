<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
        <title><?= Html::encode($this->title) ?></title>
    </head>
    <body style="font-size: 70%">
    <?php $this->beginBody(); ?>
        <?= $content ?>


    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>