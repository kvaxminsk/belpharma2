<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\Products */

$this->title = 'Редактировать сведенья о товаре: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Остатки товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mnn, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
