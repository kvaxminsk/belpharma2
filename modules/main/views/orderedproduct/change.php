<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\assets\AppAsset;
use app\components\grid\ActionProductsColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrderedProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $order app\modules\main\models\Orders */

$this->title = 'Прикрепленные к заказу товары';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 4;
$this->registerJsFile('js/ordered2.js', [
    'depends' => AppAsset::className(),
    'position' => View::POS_END,
]);
?>
<div class="ordered-product-index">

    <h1><?= Html::encode($this->title) ?> </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        Заказ на сумму: <b><?= number_format($totalPrice, 0, ',', ' ') ?> руб.</b>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [   
                'attribute' => 'kodpart',
                'value' => function($model, $key, $index, $column) {
                        return Html::a($model->kodpart, ['#'], ['class' => 'green-link desc-link']);
                },
                'format' => 'html',
            ],
            [   
                'attribute' => 'imn',
                'value' => function($model, $key, $index, $column) {
                        return Html::a($model->imn, ['#'], ['class' => 'desc-link']);
                },
                'format' => 'html',
            ],
            [
                'label' => 'Форма выпуска',
                'value' => function ($model, $key, $index, $column) {
                    $product = app\modules\main\models\Products::findOne(['kodpart' => $model->kodpart]);
                    if(isset($product)) {
                        return $product->nshort3;
                    } else {
                        return '<span class="label label-danger">сведения не найдены</span>';
                    }
                },
                'format' => 'html',
            ],
            [   
                'attribute' => 'otd',
                'value' => function($model, $key, $index, $column) {
                        return Html::a($model->otd, ['#'], ['class' => 'desc-link']);
                },
                'format' => 'html',
            ],
            [
                'label' => 'Сумма (руб.)',
                'value' => function ($model, $key, $index, $column) {
                    return number_format($model->wholesaleTotalPrice, 0, ',', ' ');
                },
                'format' => 'text'
            ],
            [
                'class' => ActionProductsColumn::className(),
                'buttonClass' => 'add-the-product'
            ],
            [   
                'attribute' => 'dsv',
                'value' => function($model, $key, $index, $column) {
                        return Html::a($model->dsv, ['#'], ['class' => 'desc-link']);
                },
                'format' => 'html',
            ],
            [
                'class' => DataColumn::className(),
                'label' => 'На складе',
                'value' => function ($model, $key, $index, $column) {
                    if($model->isProduct) {
                        return '<span class="label label-success"">В наличии</span>';
                    } else {
                        return '<span class="label label-danger">Нет</span>';
                    }
                },
                'format' => 'html'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',                
            ],
        ],
    ]); ?>
    <?php if(isset($order)) { ?>
    <p>
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($order, 'buggod')->dropDownList($order->buggodArray)->label('Тип договора') ?>
            <?= Html::submitButton('Проверить и заказать', ['class' => 'btn btn-success']); ?>
        <?php ActiveForm::end() ?>
    </p>
    <?php } ?>
    <?php if($order->id != Yii::$app->session->get('idOrder')) { ?>
        <p><?= Html::a('Добавить товары', ['/main/orderedproduct/checkout-other', 'id' => $order->id], ['class' => 'btn btn-success']) ?></p>
        <p class="alert alert-success">В случае добавления новых товаров в этот заказ, он будет активизирован, как оформляемый.</p>
        <?php if(!empty(Yii::$app->session->get('idOrder'))) { ?>
        <p class="alert alert-warning">В данный момент вы начали <a href="<?= Url::toRoute(['/main/orderedproduct/checkout']) ?>">оформление заказа №<?= Yii::$app->session->get('idOrder') ?></a>.</p>
        <?php } ?>
    <?php } ?>
</div>
<?= $this->render('@app/views/modals/descriptionProduct') ?>