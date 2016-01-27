<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\OrdersHandlerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 2;
$options = ['class' => 'form-control'];
?>
<div class="orders-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => DataColumn::className(),
                'attribute' => 'id',
                'filter' => Html::activeTextInput($searchModel, 'id', $options),
                'value' => 'id',
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'format' => 'datetime'
            ],
            [
                'class' => DataColumn::className(),
                'label' => 'Товаров',
                'value' => 'countProducts'
            ],
            [
                'class' => DataColumn::className(),
                'label' => 'Cумма',
                'attribute' => 'totalPriceForOrder',
            ],
            [
                'class' => DataColumn::className(),
                'filter' => Html::activeTextInput($searchModel, 'nameUser', $options),
                'attribute' => 'user_id',
                'label' => 'Наименование контрагента',
                'value' => 'contragentName'
            ],
            [
                'class' => DataColumn::className(),
                'filter' => Html::activeTextInput($searchModel, 'codUser', $options),
                'attribute' => 'user_id',
                'label' => 'Код контрагента',
                'value' => 'contragentCod'
            ],
            // 'repeated',
            // 'buggod',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{repeatSend}',
                'buttons' => [
                    'repeatSend' => function($url, $model, $key) {
                        return Html::a("<span class=\"glyphicon glyphicon-upload\"></span>", ['repeat-send', 'id' => $model->id], [
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Вы точно хотите сгенерировать и отправить повторно xml-файл заявки на ftp-сервер',
                            ],
                            'title' => 'Отправить повторно на ftp-сервер заказ'
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>