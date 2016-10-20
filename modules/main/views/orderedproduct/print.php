<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\assets\AppAsset;
use app\components\grid\ActionProductsColumn;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrderedProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $order app\modules\main\models\Orders */

$this->title = 'Прикрепленные к заказу товары';
?>
    <?php if(empty($order)) { ?>
    <p class="alert alert-danger">
        Перейдите в раздел <?= Html::a("Остатки товаров", ['/main/products']) ?>, выбирите товар и прикрепите к заказу. Сейчас у Вас не добавлено ни одного товара в заказ.
    </p>

    <?php } ?>
<p>Наименование организации:  <?= !empty(Yii::$app->user->identity->name) ? Yii::$app->user->identity->name : Yii::$app->user->identity->username ?></p>
<p>номер заказа: <?=$order->id;?></p>
<p>тип договора: <?= $order->buggodName ?></p>
<style>
    .table {
        border:1px solid black;
        
    }
    .table td, th {
        text-align:center;
        border:1px solid black;
        padding:0px;
    }
</style>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => "",
        'columns' => [
            [
                'label' => 'Торговое наименование',
                'value' => function($model, $key, $index, $column) {
                        return $model->imn;
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
                        return '<span class="label label-danger">-</span>';
                    }
                },
                'format' => 'html',
            ],
            [
                'label' => 'Производитель',
                'value' => function($model, $key, $index, $column) {
                    return $model->dsv;
                },
                'format' => 'html',
            ],
            [   
                'label' => 'Год тендера',
                'value' => function($model, $key, $index, $column) {
                    $product = app\modules\main\models\Products::findOne(['kodpart' => $model->kodpart]);
                    if(isset($product)) {
                        return $product->tendergod;
                    } else {
                        return '-';
                    }
                },
                'format' => 'html',
            ],
            [
                'label' => 'Отдел склада',
                'value' => function($model, $key, $index, $column) {
                    return $model->otd;
                },
                'format' => 'html',
            ],
            [
                'label' => 'Заказанное количество',
                'value' => function($model, $key, $index, $column) {
                        return $model->kolz;
                },
                'format' => 'html',
            ],
            [
                'label' => 'Стоимость, руб',
                'value' => function($model, $key, $index, $column) {
                    $product = app\modules\main\models\Products::findOne(['kodpart' => $model->kodpart]);

                    if(isset($product)) {
                        $userId = Yii::$app->user->getId();
                        $userModel = User::getById($userId);
                        if ($userModel->isCenDogovor())
                        {
                            $cena =  $product->cendogovor;
                        }
                        else
                        {
                            $cena = $product->cenopt;
                        }
                        return number_format($cena*$model->kolz,  2, ' руб ', ' ') . 'коп';
                    } else {
                        return '<span class="label label-danger">-</span>';
                    }
                },
                'format' => 'html',
            ],
            [
                'label' => 'Ставка НДС, %',
                'value' => function($model, $key, $index, $column) {
                    $product = app\modules\main\models\Products::findOne(['kodpart' => $model->kodpart]);
                    if(isset($product)) {
                        return $product->nds;
                    } else {
                        return '<span class="label label-danger">-</span>';
                    }
                },
                'format' => 'html',
            ],
            [
                'label' => 'Стоимость с НДС, руб',
                'value' => function($model, $key, $index, $column) {
                    return number_format($model->wholesaleTotalPrice,  2, ' руб ', ' ') . 'коп';
                },
                'format' => 'html',
            ],
        ],
    ]); ?>
<p>Итого стоимость без НДС: <?= number_format($totalPriceWithoutNds, 2, ' руб ', ' ') . 'коп' ?> </p>
<p>Итого стоимость с НДС: <?= number_format($totalPrice,  2, ' руб ', ' ') . 'коп' ?></p>
