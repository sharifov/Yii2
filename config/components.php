<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
return [
    'cache' => [
        'class' => \yii\caching\FileCache::class,
        'cachePath' => '@cache',
        'keyPrefix' => 'fv'
    ],
    'session' => [
        'class' => \yii\web\DbSession::class,
//        Set the following if you want to use DB component other than
        'db' => 'coredb',
//            To override default session table, set the following
        'sessionTable' => 'fv_session',
    /*
      CREATE TABLE fv_session (
      id CHAR(40) NOT NULL PRIMARY KEY,
      expire INTEGER,
      data BLOB
      )
     */
    ],
    'request' => [
        'class' => \thread\components\Request::class,
        'enableCsrfValidation' => true,
        'enableCookieValidation' => true,
        'cookieValidationKey' => 'thread'
    ],
    'urlManager' => [
        'class' => \thread\components\UrlManager::class,
        'enablePrettyUrl' => true,
        'enableStrictParsing' => true,
        'showScriptName' => false,
    ],
    'errorHandler' => [
        'errorAction' => 'home/home/error',
    ],
    'user' => [
        'absoluteAuthTimeout'=>3600*12,
        'authTimeout' => 3600*11, //11 saat
        'autoRenewCookie'=>true,
        'class' => \yii\web\User::class,
        'identityClass' => \thread\modules\user\models\User::class,
        'enableAutoLogin' =>true,
        'loginUrl' => ['/user/login']
    ],
    'authManager' => [
        'class' => \yii\rbac\DbManager::class,
    ],
    'i18n' => [
        'translations' => [
            'app' => [
                'class' => \yii\i18n\PhpMessageSource::class,
                'basePath' => '@thread/app/messages',
                'fileMap' => [
                    'app' => 'app.php',
                ]
            ],
            'date' => [
                'class' => \yii\i18n\PhpMessageSource::class,
                'basePath' => '@thread/app/messages',
                'fileMap' => [
                    'app' => 'date.php',
                ]
            ],
        ]
    ],
    'assetManager' => [
        'class' => \yii\web\AssetManager::class,
        'appendTimestamp' => true,
        //Використовуємо для постійного оновлення assets
        //потрібно для верстальника
        //обовязково очистити директорію /frontend/assets
        'linkAssets' => false,
    ],
    'image' => [
        'class' => \yii\image\ImageDriver::class,
        'driver' => 'GD', //GD or Imagick
    ],
    'mail' => [
        'class' => yii\swiftmailer\Mailer::class,
        'viewPath' => '@common/mail',
        'useFileTransport' => true,
        'enableSwiftMailerLogging' => false,
    ],
];
