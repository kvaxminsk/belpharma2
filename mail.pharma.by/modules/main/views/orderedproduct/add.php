<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\OrderedProduct */
/* @var $product app\modules\main\models\Products */

$this->title = 'Информация о товаре';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['/main/products/index']];
$this->params['breadcrumbs'][] = ['label' => $product->tn . '(Форма выпуска: ' . $product->nshort3 . ')', 'url' => ['/main/products/view', 'id' => $product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordered-product-add">

    
    <div class="panel panel-warning">
        <div class="panel-heading">Добавление товара к заявке<?= Yii::$app->session->get('creatingOrder') == true ? ' (В процессе создания заявки на заказ)' : ' (Будет создана новая заявка)' ?></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin() ?>
                <?= $form->field($model, 'kolz') ?>
                <?= Html::submitButton('Прикрепить товар к заявке', ['class' => 'btn btn-success']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
    
    
    <h1><?= Html::encode($this->title) ?></h1>
        
    <?= DetailView::widget([
        'model' => $product,
        'attributes' => [
            'mnn',
            'tn',
            'kpr',
            'nshort3',
            'namepr',
            'country',
            'otd',
            [
                'attribute' => 'osnls',
                'value' => $product->osnlsName,
            ],
            'tender',
            'spar',
            'goden_do',
            'cenopt',
            'cenrozn',
            'kol',
            'tendergod',
            'vidtovara',
            'obnalichie',
            'kolotgr',
            'vidpost',
        ],
    ]) ?>

</div>
