<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrderedProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проверьте Ваш заказ';
$this->params['breadcrumbs'][] = ['label' => 'Прикрепленные к заказу товары', 'url' => ['/main/orderedproduct/checkout']];
$this->params['breadcrumbs'][] = 'Подтверждение заказа';
$this->params['menu'] = 3;
?>
<div class="ordered-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        Ваш заказ на сумму: <b><?= number_format($totalPrice, 0, ',', ' ') ?> руб.</b><br>
        Тип договора: <b><?= $buggod ?></b>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'kpr',
            'imn',
            'otd',
            [
                'label' => 'Сумма (руб.)',
                'value' => function ($model, $key, $index, $column) {
                    return number_format($model->wholesaleTotalPrice, 0, ',', ' ');
                },
                'format' => 'text'
            ],
            'kolz',
            'dsv',
            // 'buggod',
            // 'status',
            // 'user_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <p>
        <?= Html::a('Отправить', ['send-order', 'id' => Yii::$app->session->get('idOrder')], [
            'class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>