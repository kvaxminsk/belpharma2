<?php

return [    
    'components' =>[
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=belfarmaciya',
            'username' => 'root',//'pharmadbu',
            'password' => ''//'QMm2My455m',
        ],        
        'mailer' => [
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],        
    ]
];
