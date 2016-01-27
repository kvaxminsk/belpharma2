<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\main\models\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
$close = [
    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon"><span class="glyphicon glyphicon-remove-circle clear-input"></span></span></div>'
];
$fc = ['class' => 'form-control'];
$countries = ArrayHelper::map($countries, 'name', 'name');
?>
<?php //var_dump($countries) ?>
<div class="products-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        //'layout' => 'horizontal',
        'id' => 'search-product-form',
        
      'fieldConfig' => [
          'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
          'horizontalCssClasses' => [
              'label' => 'col-sm-4',
              'offset' => 'col-sm-offset-4',
              'wrapper' => 'col-sm-8',
              'error' => '',
              'hint' => '',
          ],
      ],
    ]); ?>

    <div class="col-sm-4">
        <?= $form->field($model, 'tn', $close) ?>
        <?= $form->field($model, 'nshort3', $close) ?>
        <?= $form->field($model, 'mnn', $close) ?>
        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Сброс', ['class' => 'btn btn-default clear-button']) ?>
        </div>
    </div>
    <div class="col-sm-4">
        <?php echo $form->field($model, 'namepr', $close) ?>
        <?php echo $form->field($model, 'country')->widget(Select2::className(), [
            'model' => $model,
            //'attribute' => 'country',
            'data' => $countries,
            'theme' => Select2::THEME_BOOTSTRAP,
        ]) ?>
        <div class="row">
            <div class="col-sm-6">
            <?php echo $form->field($model, 'godenDoFrom', $close)->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => array_merge($fc, $close, ['placeholder' => 'Нач-я дата']),
            ]) ?>
            </div>
            <div class="col-sm-6">
            <?php echo $form->field($model, 'godenDoTo', $close)->widget(DatePicker::className(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => array_merge($close, $fc, ['placeholder' => 'Конеч-я дата']),
            ])->label('&nbsp;') ?>
            </div>
        </div>
        <?php echo $form->field($model, 'otd', $close) ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->field($model, 'osnls')->dropDownList([
            '' => 'Не выбрано',
            1 => 'ОС',
            0 => '-'
        ]) ?>
        <?php echo $form->field($model, 'vidpost')->dropDownList([
            '' => 'Не выбрано',
            'Обычная поставка' => 'Обычная поставка',
            'Централизованный тендер' => 'Централизованный тендер'
        ]) ?>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->field($model, 'kolFrom', $close)->textInput(['placeholder' => 'от']) ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->field($model, 'kolTo', $close)->textInput(['placeholder' => 'до'])->label('&nbsp;') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
            <?php echo $form->field($model, 'cenaoptFrom', $close)->textInput(['placeholder' => 'от'])  ?>
            </div>
            <div class="col-sm-6">
            <?php echo $form->field($model, 'cenaoptTo', $close)->textInput(['placeholder' => 'до'])->label('&nbsp;')  ?>
            </div>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>
</div>
