<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
require(__DIR__ . '/alias.php');

return \yii\helpers\ArrayHelper::merge([
    'vendorPath' => '@vendor',
    'sourceLanguage' => 'zu-Za',
    'language' => 'ru-RU',
    'charset' => 'utf-8',
    'timeZone' => 'Europe/Kiev',
    'extensions' => require($rootDir . '/vendor/yiisoft/extensions.php'),
    'components' => \yii\helpers\ArrayHelper::merge(require(__DIR__ . '/components.php'), require(__DIR__ . '/db.php')),
    'params' => require(__DIR__ . '/params.php')
], require(__DIR__ . '/main-local.php'));
