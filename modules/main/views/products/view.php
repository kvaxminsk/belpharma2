<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\modules\main\models\Products;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\Products */

$this->title = $model->mnn . ' (Форма выпуска: ' . $model->nshort3 . ')';
$this->params['breadcrumbs'][] = ['label' => 'Остатки товаров', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php if(\Yii::$app->user->identity->role == 1) { ?>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить из бд этот товар?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mnn',
            'tn',
            'nshort3',
            'namepr',
            'country',
            'otd',
            [
                'attribute' => 'osnls',
                'value' => $model->osnlsName,                
            ],
            [
                'attribute' => 'tender',
                'value' => $model->tenderName,
            ],
            'spar',
            'goden_do',
            'cenopt',
            'cendogovor',
            'cenrozn',
            'kol',
            'tendergod',
            'vidtovara',
            [
                'attribute' => 'obnalichie',
                'value' => $model->obnalichieName,
            ],
            'kolotgr',
            'vidpost',
        ],
    ]) ?>
    
    <?= Html::a('<  Вернутся к списку товаров', ['index'], ['class' => 'btn btn-primary']) ?>
    <?php if(Yii::$app->user->identity->role != 1) { ?>
    <?php if(Yii::$app->session->get('creatingOrder') == 1) { ?>
            <?= Html::a('Добавить к заказу', Url::toRoute(['/main/orderedproduct/add', 'id' => $model->kodpart]), ['class' => 'btn btn-primary']) ?>
    <?php } else { ?>
            <?= Html::a('Создать новый заказ и добавить в него товар', Url::toRoute(['/main/orderedproduct/add', 'id' => $model->kodpart]), ['class' => 'btn btn-primary']) ?>
    <?php } ?>
    <?php } ?>
</div>
