<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__.'/params.php'),
    require(__DIR__.'/params-local.php')
);

return [
    'id' => 'basic',
    'name' => 'РУП «Белфармация»',
    'language' => 'ru',
    'timeZone' => 'Atlantic/Azores',//Europe/London 
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'on afterRequest' => function() {
        \app\components\info\BrowserDefined::isIE();
    },
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'main/default/index',
                'contact' => 'main/contact/index',
                '<_a:error>' => 'main/default/<_a>',                
                '<_a:(login|logout|signup|confirm-email|request-password-reset|reset-password)>' => 'user/default/<_a>',
                
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',                
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',            
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ]
            ],
            
        ],
        'formatter' => [
                'dateFormat' => 'dd/MM/yyyy',
                'datetimeFormat' => 'HH:mm:ss dd/MM/yyyy',
            ]
    ],
    'modules' => [
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
    ],
    'params' => $params,
];

