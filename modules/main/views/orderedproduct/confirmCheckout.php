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
        Ваш заказ на сумму: <b><?= number_format($totalPrice,  2, ' руб ', ' ') . 'коп' ?></b><br>
        Тип договора: <b><?= $buggod ?></b>
        <a style="float: right;margin-right: -190px;" href="/main/orderedproduct/print"><img src="/img/print-icon.png"/></a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'kodpart',
            'imn',
            'otd',
            [
                'label' => 'Ставка НДС',
                'value' => function ($model, $key, $index, $column) {
                    $product = app\modules\main\models\Products::findOne(['kodpart' => $model->kodpart]);
                    if(isset($product)) {
                        return $product->nds;
                    } else {
                        return 0;
                    }
                },
                'format' => 'text'
            ],
            [
                'label' => 'Сумма с НДС',
                'value' => function ($model, $key, $index, $column) {
                    return number_format($model->wholesaleTotalPrice,  2, ' руб ', ' ') . 'коп';
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