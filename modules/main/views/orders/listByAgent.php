<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;
use app\modules\main\models\Orders;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user app\modules\user\models\User */

$this->title = 'История заказов агента ' . $user->username . '';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 6;
$session = Yii::$app->session;
?>
<div class="orders-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'updated_at',
            [
                'class' => DataColumn::className(),
                'label' => 'Товаров',
                'value' => 'countProducts'
            ],
            [
                'label' => 'Cумма',
                'attribute' => 'totalPriceForOrder',
            ],
            [
                'attribute' => 'status',
                'value' => 'statusName',
                'filter' => Orders::getStatusArray(),
            ],
            [
                'class' => 'yii\grid\ActionColumn', 
                'template' => '{view} {confirmOrder}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['/main/orderedproduct/confirm-checkout-by-admin', 'id' => $model->id], [
                            'title' => 'Товары в заказе'
                        ]);
                    },
                    'confirmOrder' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-circle-arrow-up"></span>', ['status-confirm', 'id' => $model->id],[
                            'title' => 'Подтвердить заказ',
                            'data' => [
                                'method' => 'post',
                            ]
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
