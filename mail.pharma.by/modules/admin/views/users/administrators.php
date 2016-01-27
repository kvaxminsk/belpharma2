<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\admin\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Администраторы';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 7;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать администратора', ['create-admin'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'username',
            'email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update-admin', 'id' => $model->id], [
                            'title' => 'Редактировать'
                        ]);
                    },
                    'delete' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-admin', 'id' => $model->id], [
                            'title' => 'Удалить',
                            'data' => [
                                'method' => 'post',
                                'confirm' => 'Вы уверены, что хотите удалить выбранного администратора?',
                            ]
                        ]);
                    },                            
                ],
            ],
        ],
    ]); ?>
</div>
