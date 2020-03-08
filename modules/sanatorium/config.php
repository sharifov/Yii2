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
        ],
        'creditCardTypes' => [
            'American Express' => 'American Express',
            'VISA' => 'VISA',
            'Master Card' => 'MasterCard',
            'Maestro' => 'Maestro',
            'DCI' => 'DCI',
            'Visa Electron' => 'Visa Electron',
            'JCB' => 'JCB',
            'Diners Club' => 'Diners Club',
            /*'Mir' => 'Мир',*/
        ],
    ],
    'title' => 'Sanatorium',
    'fileUploadFolder' => 'frontend/upload/sanatorium',
    //Migration
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],
];
