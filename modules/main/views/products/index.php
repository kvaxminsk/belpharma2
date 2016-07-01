<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\ArrayHelper;
//use kartik\grid\GridView;
use kartik\select2\Select2;
use app\modules\main\models\Products;
use app\components\grid\ActionProductsColumn;
use app\assets\AppAsset;
use app\components\widgets\InputWithClose;
//var_dump($f);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $orderedProducts app\modules\main\models\OrderedProduct */
/* @var $model app\modules\main\models\Products */
$this->registerJsFile('js/ordered.js', [
    'depends' => AppAsset::className(),
    'position' => View::POS_END,
]);
$this->title = 'Остатки товаров';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 1;

$columns = [
    [
        'attribute' => 'tn',
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->tn, ['#'], ['class' => 'green-link desc-link']);
        },
        'format' => 'html',
        'label' => 'Торговое<br>наименование',
        'encodeLabel' => false,
        'headerOptions' => ['class' => 'abc'],
    ],
    [
        'attribute' => 'nshort3',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'nshort3']),
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->nshort3, ['#'], ['class' => 'desc-link']);
        },
        'format' => 'html',
        'label' => 'Форма<br>выпуска',
        'encodeLabel' => false,
    ],
    [
        'attribute' => 'mnn',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'mnn']),
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->mnn, ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Международное<br>наименование',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        'attribute' => 'namepr',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'namepr']),
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->namepr, ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Наименование<br>производителя',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        'attribute' => 'country',
        //'filterType' => GridView::FILTER_SELECT2,
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->country, ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Страна<br>производства',
        'encodeLabel' => false,
        'format' => 'html',             
    ],
    [
        'attribute' => 'goden_do',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'goden_do']),
        'value' => function($model, $key, $index, $column) {
            return Html::a(Yii::$app->formatter->asDate($model->goden_do), ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Срок<br>годности',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        'attribute' => 'otd',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'otd']),
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->otd, ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Отдел<br>склада',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        //'filter' => Products::getOsnlsArray(),
        'attribute' => 'osnls',
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->osnlsName, ['#'], ['class' => 'desc-link']);
        },
        
        'label' => 'Признак<br>основного ЛС',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        'attribute' => 'vidpost',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'vidpost']),
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->vidpost, ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Вид<br>поступления',
        'encodeLabel' => false,
        'format' => 'html',
        'filter' => [
            'Обычная поставка' => 'Обычная поставка',
            'Централизованный тендер' => 'Централизованный тендер',
        ],
    ],
    [
        'attribute' => 'kol',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'kol']),
        'value' => function($model, $key, $index, $column) {
            return Html::a($model->kol . ' шт.', ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Количество<br>на складе',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        'attribute' => 'cenopt',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'cenopt']),
        'value' => function($model, $key, $index, $column) {
            return Html::a(number_format($model->nds, 0, ',', ' ') . ' руб.', ['#'], ['class' => 'desc-link']);
        },
        'label' => 'НДС<br>',
        'encodeLabel' => false,
        'format' => 'html',
    ],
    [
        'attribute' => 'cenopt',
        //'filter' => InputWithClose::widget(['model' => $searchModel, 'attribute' => 'cenopt']),
        'value' => function($model, $key, $index, $column) {
            return Html::a(number_format($model->cenopt, 0, ',', ' ') . ' руб. ', ['#'], ['class' => 'desc-link'] ) . '<br>' . Html::a( number_format($model->cenopt/10000, 2, ' руб.', '') . ' коп.', ['#'], ['class' => 'desc-link']);
        },
        'label' => 'Цена оптовая<br>без НДС',
        'encodeLabel' => false,
        'format' => 'html',
    ],
];
$actionColumn = [
    [
        'class' => ActionProductsColumn::className(),
        'contentOptions' => [
            'class' => 'action-products-column',
        ],
        "header" => 'Действие',
    ]
];
?>

<div class="products-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', [
        'model' => $searchModel,
        'countries' => $countries,
    ]) ?>
    <?php if (Yii::$app->user->identity->role == 2) { ?>

        <?=
        GridView::widget([
            'tableOptions' => ['class' => 'table table-striped table-bordered  table-hover'],
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => array_merge($columns, $actionColumn),
        ]);
        ?>

    <?php } ?>
    <?php if (Yii::$app->user->identity->role == 1) { ?>
        <?=
        GridView::widget([
            'tableOptions' => ['class' => 'table table-striped table-bordered  table-hover'],
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $columns,            
        ]);
        ?>
    <?php } ?>

</div>
<?= $this->render('@app/views/modals/descriptionProduct') ?>