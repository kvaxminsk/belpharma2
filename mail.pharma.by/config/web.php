<?php

$config = [    
    'components' => [
        'defaultRoute' => 'main/default/index',
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,            
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],        
        'request' => [          
            'cookieValidationKey' => 'q-IJ-YKxsHRGRw4NuhSveF1YR7JaMNcB',
        ],
    ],        
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
