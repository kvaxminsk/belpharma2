<?php

$this->title = 'Zip-архив с файлами накладных';
$this->params['menu'] = 5;
?>
<h1><?= $this->title ?></h1>
<p>
    Скопированные файлы накладных с удаленного ftp-сервера:
    <ul>
        <?php $i=0; ?>
        <?php foreach($files as $file) {?>
        <li><?= $file ?> - <?= $statusesFtpGet[$i] == true ? 'скопирован' : 'не скопирован (ошибка при получении файла)' ?></li>
        <?php $i++ ?>
        <?php } ?>
    </ul>
</p>
<p>
    Архивирование скопированных файлов накладных:
    <ul>
        <?php $i=0; ?>
        <?php foreach($files as $file) {?>
        <li><?= $file ?> - <?= $statusesZipArchive[$i] === true ? 'добавлен в архив' : 'не добавлен в архив (ошибка при архивировании файла)' ?></li>
        <?php $i++ ?>
        <?php } ?>
    </ul>
</p>
<div>
    <p>Информация об архиве с накладными:</p>
    <p>Содержит файлов: <?= $zipInfo['numfiles'] ?></p>
    
    <a href="/<?= $zipFolder . $filenameZip ?>" class="btn btn-success">Скачать архивом с ftp-сервера</a>
</div>