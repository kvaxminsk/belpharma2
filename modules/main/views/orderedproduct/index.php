<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\main\models\OrderedProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ordered Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ordered-product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ordered Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kpr',
            'imn',
            'otd',
            'kolz',
            // 'dsv',
            // 'buggod',
            // 'status',
            // 'user_id',

            [
                'class' => 'yii\grid\ActionColumn'
                
            ],
        ],
    ]); ?>

</div>
