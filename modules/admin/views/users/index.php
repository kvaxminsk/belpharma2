<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'CONTRAGENTS_TITLE');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'CONTRAGENT_CREATE_USER'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'cod',
            'username',
            'name',
            'phone',
            'address',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{orders} {view} {update} {delete}',
                'buttons' => [
                    'orders' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['/main/orders/list-by-agent', 'id' => $model->id], [
                            'title' => 'Список заказов'
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>

</div>
