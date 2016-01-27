<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * Description of Html5ShivAsset
 *
 * @author mr
 */
class Html5ShivAsset extends AssetBundle 
{
    public $sourcePath = '@bower/html5shiv/dist';
    public $js = [
        'html5shiv.min.js',
    ];
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD,
    ];
}
