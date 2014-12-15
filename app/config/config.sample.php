<?php

define('HOSTNAME', 'my-domain.com');

return [
    'application' => [
        'environment'    => \Vegas\Constants::DEV_ENV,

        'serviceDir'   =>  APP_ROOT . '/app/services/',
        'configDir'     => dirname(__FILE__) . DIRECTORY_SEPARATOR,
        'libraryDir'     => APP_ROOT . DIRECTORY_SEPARATOR . 'lib/',
        'pluginDir'      => APP_ROOT . '/app/plugins/',
        'moduleDir'      => APP_ROOT . '/app/modules/',
        'taskDir'      => APP_ROOT . '/app/tasks/',
        'baseUri'        => '/',
        'language'       => 'en_US',
        'view'  => [
            'cacheDir'  =>  APP_ROOT . '/cache/',
            'layout'    =>  'main',
            'layoutsDir'    =>  APP_ROOT . '/app/layouts'
        ],

        //'hostname'    =>  HOSTNAME    // uncomment when you are using subdomains
    ],

    'mongo' => [
        'dbname' => 'vegas_official',
        //see app/services/MongoServiceProvider.php to get more information how to setup database details
    ],

    'session' => [
        'cookie_name'   =>  'sid',
        'cookie_lifetime'   =>  36*3600, //day and a half
        'cookie_secure' => 0,
        'cookie_httponly' => 1,
        'cookie_domain' => '.' . HOSTNAME // sessions across sub-domains
    ],

    'plugins' => [
        'security' => [
            'class' => 'SecurityPlugin',
            'attach' => 'dispatch'
        ]
    ],

    'mail' => [
        'admin' => [
            'name' => 'Vegas CMF Team',
            'email' => 'vegas@amsterdam-standard.pl'
        ],
        'smtp' => [
            'host' => 'MY_SMTP_HOST',
            'port' => 587,
            'username' => 'MY_SMTP_USERNAME',
            'password' => 'MY_SMTP_PASSWORD'
        ]
    ]
];