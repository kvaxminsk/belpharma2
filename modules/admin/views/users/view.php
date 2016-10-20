<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Агент #' . $model->cod;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'CONTRAGENTS_TITLE'), 'url' => ['contragents']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 6;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'BTN_UPDATE'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'BTN_DELETE'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cod',
            'username',
            'name',
            'address',
            'group',
            'phone',
            'email:email',
            'responsible_person',
        ],
    ]) ?>

</div>
