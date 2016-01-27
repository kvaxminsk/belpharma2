<?php

namespace app\assets;

use yii\web\AssetBundle;

class LoginAsset extends AssetBundle 
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
    ];
    public $js = [
        'js/validate.js',
    ];
    public $depends = [
        'app\assets\Html5ShivAsset',
        'app\assets\RespondAsset',
    ];
}
