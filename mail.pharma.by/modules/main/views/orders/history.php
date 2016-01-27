<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\modules\main\models\Orders;
use app\components\grid\ActionHistoryColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История заказов';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 4;
$session = Yii::$app->session;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if(empty($session->get('creatingOrder')) || $session->get('creatingOrder') == 0) { ?>
            <?= Html::a('Создать заказ', ['create-order'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    
    <p>
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'updated_at')->label('Удалить из истории заявки ранее чем')->widget(DatePicker::className(), [
            'dateFormat' => 'yyyy-MM-dd 23:59:59',
            'options' => ['class' => 'form-control', 'style' => 'width: 300px; margin-left: 10px;', 'placeholder' => 'Дата' ],
        ]) ?>
        <?= Html::submitButton('Удалить', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'updated_at:datetime',
            [
                'class' => DataColumn::className(),
                'label' => 'Товаров',
                'value' => 'countProducts'
            ],
            [
                'label' => 'Cумма (руб.)',
                'attribute' => 'totalPriceForOrder',
                'format' => 'text',
            ],
            [
                'attribute' => 'status',
                'value' => 'statusName',
                'filter' => Orders::getStatusArray(),
            ],
            'count_repeat',
            [
                'class' => ActionHistoryColumn::className(),
            ]
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
