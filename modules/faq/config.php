<?php

/**
 * @author zndron
 * @copyright (c) 2016, Thread
 */
return [
    'title' => 'faq',
    //Migration
    'controllerMap' => [
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => __DIR__ . '/migrations',
        ],
    ],
];
