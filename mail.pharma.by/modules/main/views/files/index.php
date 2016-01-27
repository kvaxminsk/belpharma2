<?php
use yii\helpers\Url;
/* @var files array is names of files :) */
$this->title = 'Электронные накладные';
$this->params['menu'] = 5;
?>
<h1><?= $this->title ?></h1>

<p class="alert alert-success">
    Файлы для скачивания:<br>
    <a href="/files/manual.zip"><b>Инструкция  по  работе с программой</b></a><br>
    <a href="/files/phones.zip"><b>Телефонный  справочник  аптечного  склада</b></a>
</p>

<?php if(!empty($files)) { ?>

<div class="panel panel-default">
    <div class="panel panel-heading">Новые накладные</div>
    <div class="panel-body">
        <p>
            <a href="<?= Url::toRoute(['generate-invoices']) ?>" class="btn btn-primary">Сгенерировать zip-архив с накладными для скачивания</a>
        </p>
        <p class="alert alert-warning">Ниже список файлов накладных доступный для Вас на ftp-сервере.</p>
        <ul class="files">
            <?php foreach ($files as $value) { ?>
            <li><img src="/img/file.png" alt="File"/><?= $value ?></li>
        <?php } ?>
        </ul>
    </div>
</div>

<?php } else { ?>

    <p class="alert alert-warning">На ftp-сервере нет файлов накладных доступных для вас.</p>    
    
<?php } ?>
<!--
<p class="alert alert-danger">Раздел в процессе разработки. То, что ниже не функционирует.</p>
<p class="alert alert-warning">Необходима ли возможность скачивания предыдущих накладных? (определение требований, функционала)</p>
    
<div class="panel panel-default">
    <div class="panel-heading">Полученные ранее накладные</div>
    <div class="panel-body">
        <a href="#" class="btn btn-success">Cписок полученных ранее файлов накладных</a>
        <a href="#" class="btn btn-success">Сгенерированные ранее архивы накладных</a>
    </div>
</div>
--> 