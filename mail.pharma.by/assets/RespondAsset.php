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
 * Description of RespondAsset
 *
 * @author mr
 */
class RespondAsset extends AssetBundle 
{
    public $sourcePath = '@bower/respond/dest';
    public $js = [
        'respond.min.js'
    ];
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD,
    ];     
}
