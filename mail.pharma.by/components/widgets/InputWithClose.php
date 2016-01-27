<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\widgets;

use yii\base\Widget;

/**
 * Description of InputWithClose
 *
 * @author mr
 */
class InputWithClose extends Widget 
{
    public $model;
    public $attribute;
    public $modelClass;
        
    public function init() 
    {
        parent::init();
    }
    
    public function run()
    {
        parent::run();
        return $this->render('inputWithClose', [
            'model' => $this->model,
            'attribute' => $this->attribute,
            'modelClass' => $this->modelClass,
        ]);
    }
}
