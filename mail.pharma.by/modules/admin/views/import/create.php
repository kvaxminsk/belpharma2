<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ImportProducts */

$this->title = 'Загрузка файла xml';
$this->params['breadcrumbs'][] = ['label' => 'Импорт товара', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 8;
?>
<div class="import-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
