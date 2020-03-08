<?php

return [
    'title' => 'Urlcache',
    'fileUploadFolder' => 'frontend/upload/company',
    //Migration
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],
];
