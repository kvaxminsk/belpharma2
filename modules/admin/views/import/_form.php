<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\ImportProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="import-products-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'filename')
            ->widget(FileInput::className(), [
                'pluginOptions' => [
                    'showPreview' => false,
                'showCaption' => false,
                'showUpload' => true,
                'browseLabel' => 'Открыть',
                'allowedFileExtension' => ['xml'],
                ]
            ])?>

    <?php ActiveForm::end(); ?>

</div>
