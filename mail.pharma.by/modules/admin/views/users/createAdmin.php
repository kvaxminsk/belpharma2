<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Создание администратора';
$this->params['breadcrumbs'][] = ['label' => 'Администраторы', 'url' => ['administrators']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_formAdmin', [
        'model' => $model,
    ]); ?>

</div>
