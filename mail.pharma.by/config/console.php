<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return [
    'id' => 'basic-console',    
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
];
