<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('app', 'USER_PROFILE_UPDATE');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'CONTRAGENTS_TITLE'), 'url' => ['contragents']];
$this->params['breadcrumbs'][] = ['label' => 'Агент №:' . $model->cod, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'USER_PROFILE_UPDATE');
$this->params['menu'] = 6;
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
