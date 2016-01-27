<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\main\models\OrderedProduct */

$this->title = 'Create Ordered Product';
$this->params['breadcrumbs'][] = ['label' => 'Ordered Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordered-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
