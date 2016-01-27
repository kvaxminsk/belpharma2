<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\main\models\Products */

$this->title = 'Создание товара';
$this->params['breadcrumbs'][] = ['label' => 'Остатки товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
