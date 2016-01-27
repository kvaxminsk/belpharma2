<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('app', 'USER_PROFILE_TITLE');
$this->params['breadcrumbs'][] = $this->title;
$config = [
    'model' => $model,
    'attributes' => [
        'username',
        'email',
    ]
]
?>
<div class="user-profile">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget($config) ?>
    <p> 
        <?= Html::a('Редактировать', ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сменить пароль', ['change-password'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>