<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\OrderedProduct */

$this->title = 'Наименование: "' . $model->imn . '"';
if(Yii::$app->user->identity->role == 2) {
    $this->params['breadcrumbs'][] = ['label' => 'Прикрепленные к заказу товары', 'url' => ['checkout']];
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->params['breadcrumbs'][] = ['label' => 'История заказов агента', 'url' => ['/main/orders/list-by-agent', 'id' => $model->user_id]];
    $this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $model->order_id, 'url' => ['/main/orderedproduct/confirm-checkout-by-admin', 'id' => $model->order_id]];
    $this->params['breadcrumbs'][] = 'Товар "' . $model->imn . '"';
}
?>
<div class="ordered-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы дейcтвительно хотите удалить этот товар из заказа?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kpr',
            'imn',
            'otd',
            'kolz',
            'dsv',
        ],
    ]) ?>

</div>
