<?php

namespace app\components\grid;

use yii\grid\ActionColumn;

/**
 * Description of ActionProductsColumn
 *
 * @author mr
 */
class ActionProductsColumn extends ActionColumn
{
    public $template = '{addProduct}';
    public $buttonClass = 'add-product';
    
    protected function initDefaultButtons() 
    {
        if(!isset($this->buttons['addProduct'])) {
            $this->buttons['addProduct'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => 'Добавить заданное количество товара к заказу',
                ], $this->buttonOptions);
                return '<div class="opt-quontity product notordered ' . $model->id . '">
                            <span class="quont-minus btn"></span>
                            <input class="id" type="hidden" value="' . $model->id . '">
                            <input class="kpr" type="hidden" value="' . $model->kpr . '">
                            <input class="kol" type="text" value="1">
                            <span class="quont-plus btn"></span>
                            <button class="btn btn-primary '. $this->buttonClass . '">Добавить</button>
                        </div> <br> <div style="display: none" class="product ordered ' . $model->id . '"><a href="#">Изменить количество <span>()</span></a></div>';
            };
        }
    }
}
