<?php

return [    
    'components' =>[
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=belfarmaciya',
            'username' => 'root',
            'password' => 'Gjkmpjdfntkm',
        ],        
        'mailer' => [
            'useFileTransport' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],        
    ]
];
