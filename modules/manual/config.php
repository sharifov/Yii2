<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
return [
    'params' => [
        'format' => [
            'date' => 'd.m.Y',
            'time' => 'i:H',
        ]
    ],
    'title' => 'Manual',
    'fileUploadFolder' => 'frontend/upload/manual',
    //Migration
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],
];