<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\user\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\OrderedProduct */

$this->title = 'Редактирование товара с кодом ' . $model->kpr;
if(Yii::$app->user->identity->role == 2) {
    $this->params['breadcrumbs'][] = ['label' => 'Прикрепленные к заказу товары', 'url' => ['checkout']];
    $this->params['breadcrumbs'][] = ['label' => 'Наименование: "' . $model->imn . '"', 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'Редактирование';
} else {
    $this->params['breadcrumbs'][] = ['label' => 'История заказов агента' , 'url' => ['/main/orders/list-by-agent', 'id' => $model->user_id]];
    $this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $model->order_id, 'url' => ['/main/orderedproduct/confirm-checkout-by-admin', 'id' => $model->order_id]];
    $this->params['breadcrumbs'][] = 'Товар "' . $model->imn . '"';
    $this->params['breadcrumbs'][] = 'Редактирование';
}
?>
<div class="ordered-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'kpr',
            'imn',
            'otd',
            'dsv',
        ],
    ]) ?>

</div>
