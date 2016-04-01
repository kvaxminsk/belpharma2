<?php

use yii\helpers\Html;
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
$this->registerJsFile('js/ordered.js', [
    'depends' => AppAsset::className(),
    'position' => View::POS_END,
]);
$this->params['menu'] = 3;
?>
<div class="ordered-product-index">

    <h1><?= Html::encode($this->title) ?> </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if(empty($order)) { ?>
    <p class="alert alert-danger">
        Перейдите в раздел <?= Html::a("Остатки товаров", ['/main/products']) ?>, выбирите товар и прикрепите к заказу. Сейчас у Вас не добавлено ни одного товара в заказ.
    </p>
    <?php } else { ?>
    <p>
        Ваш заказ на сумму: <b><?= number_format($totalPrice, 0, ',', ' ') ?> руб.</b>
    </p>
    <?php } ?>
    
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
    <?php if(isset($order) && $validOrder) { ?>
    <p>
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($order, 'buggod')->dropDownList($order->buggodArray)->label('Тип договора') ?>
            <?= Html::submitButton('Проверить и заказать', ['class' => 'btn btn-success']); ?>
        <?php ActiveForm::end() ?>
    </p>
    <?php } else { ?>
    <div class="alert alert-danger">В заявке присутствуют товары отсутствующие на складе. Для совершения отправки этой заявки необходимо удалить из нее все товары отсутсвующие на складе. Для этого нажмите пиктограмму "Корзина" на тех товарах, которых нет в наличии. </div>
    <div class="alert alert-warning">Ограничение: одна заявка не может содержать более 100 товаров</div>
    <?php } ?>
</div>
<?= $this->render('@app/views/modals/descriptionProduct') ?>