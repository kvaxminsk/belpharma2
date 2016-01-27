<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('app', 'USER_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => 'Администраторы', 'url' => ['administrators']];
$this->params['breadcrumbs'][] = Yii::t('app', 'USER_PROFILE_UPDATE') . ' ' . $model->username;
$this->params['menu'] = 7;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_formAdmin', [
        'model' => $model,
    ]); ?>

</div>
