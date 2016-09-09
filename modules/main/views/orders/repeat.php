<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;
use app\modules\main\models\Orders;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrderedProductSearch */
/* @var $order app\modules\main\models\Orders */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($order->status == Orders::STATUS_SENDED) {
    $this->title = 'Повторная отправка заказа. Подтверждение.';
    $submitText = 'Отправить повторно';
} else {
    $this->title = 'Отправка неоформленного заказа. Подтверждение.';
    $submitText = 'Отправить';
}

$this->params['breadcrumbs'][] = ['label' => 'Прикрепленные к заказу товары', 'url' => ['/main/orderedproduct/checkout']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 4;

?>
<div class="ordered-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        Ваш заказ на сумму: <b><?= number_format($totalPrice,  2, ' руб ', ' ') . 'коп' ?></b><br>
        Тип договора: <b><?= $order->buggodName ?></b>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            'kodpart',
            'imn',
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
                    return number_format($model->wholesaleTotalPrice, 0, ',', ' ');
                },
                'format' => 'text'
            ],
            'kolz',
            'dsv',
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
        ],
    ]); ?>
    
    <p>
        <?php if($validOrder) { ?>
        <?= Html::a($submitText, ['/main/orderedproduct/send-order-from-history-page', 'id' => $order->id], [
            'class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
        <?php } else { ?>
    <div class="alert alert-danger">В заявке присутствуют товары отсутствующие на складе. Для совершения повторной отправки этой заявки необходимо удалить из нее все товары отсутсвующие на складе. Для этого нажмите кнопку "Изменить", а далее удалите товары отсутсвующие на складе нажав пиктограмму "Корзина". <br><br>Или не изменяйте эту заявку, а оформите новую. Возможно, что товары отсутсвующие сейчас на складе, появятся в будущем, тогда этот шаблон заявки сохранится в неизменном виде.</div>
    <div class="alert alert-warning">Ограничение: одна заявка не может содержать более 200 товаров</div>
        <?php } ?>
        
        <?= Html::a('Изменить', ['/main/orderedproduct/change', 'id' => $order->id], [
            'class' => 'btn btn-primary',
        ]) ?>
    </p>

</div>