<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = Yii::t('app', 'CONTRAGENT_CREATION_USER');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'CONTRAGENTS_TITLE'), 'url' => ['contragents']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
