<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ImportProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Импорт товара в веб-приложение';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 8;
?>
<div class="import-products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Импортировать товары из xml-файла', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'updated_at:datetime',
            'countDb',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{report} ',
                'buttons' => [
                    'report' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['report', 'id' => $model->id]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>
