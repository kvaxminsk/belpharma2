<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ImportProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчет по импорту товаров в БД-приложения из xml-файла';
$this->params['breadcrumbs'][] = $this->title;
$this->params['menu'] = 8;
?>
<div class="import-products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Назад', ['index'], ['class' => 'btn btn-primary']); ?>
    </p>
    
    <div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'created_at',
                [
                    'attribute' => 'user_id',
                    'label' => 'Е-майл администратора, который произвел импорт',
                    'value' => $user->email,
                    'format' => 'email',
                ],
                [
                    'attribute' => 'filename',
                    'value' => $model->filename . ' ' . Html::a('(Скачать)', ["/import/$model->filename"]),
                    'format' => 'html',
                ],
                'countXml',
                'countDb',
                'notImport:html',
            ]
        ]) ?>
    </div>
</div>
