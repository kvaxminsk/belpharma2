<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrderedProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказ №' . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'История заказов агента', 'url' => ['/main/orders/list-by-agent', 'id' => $order->user_id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 3;
?>
<div class="ordered-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        Общая сумма заказа: <b><?= $totalPrice ?></b> / <?= number_format($totalPrice/10000, 2, ' руб.', '') . ' коп.'?><br>
        Тип договора: <b><?= $order->buggod ?></b>
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
                    $byn = '/ ' .number_format(($model->wholesaleTotalPrice)/10000, 2, ' руб.', '');;
                    return number_format($model->wholesaleTotalPrice, 0, ',', ' '). " руб. " .
                    $byn . ' коп.' ;
                },
                'format' => 'text'
            ],
            'kolz',
            'dsv',
            // 'buggod',
            // 'status',
            // 'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
</div>