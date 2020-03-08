<?php

/**
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
$rootDir = dirname(dirname(__DIR__));
Yii::setAlias('root', $rootDir);
//
Yii::setAlias('thread', dirname(__DIR__));
Yii::setAlias('temp', $rootDir . DIRECTORY_SEPARATOR . 'temp');
Yii::setAlias('console', $rootDir . DIRECTORY_SEPARATOR . 'console');
Yii::setAlias('cache', $rootDir . DIRECTORY_SEPARATOR . 'cache');
Yii::setAlias('vendor', $rootDir . DIRECTORY_SEPARATOR . 'vendor');
Yii::setAlias('frontend', $rootDir . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'core');
Yii::setAlias('web-frontend', $rootDir . DIRECTORY_SEPARATOR . 'frontend');
Yii::setAlias('backend', $rootDir . DIRECTORY_SEPARATOR . 'extranet' . DIRECTORY_SEPARATOR . 'core');
Yii::setAlias('web-backend', $rootDir . DIRECTORY_SEPARATOR . 'backend');
Yii::setAlias('web-frontend-upload', $rootDir . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'upload');
Yii::setAlias('admin', $rootDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'core');
Yii::setAlias('web-admin', $rootDir . DIRECTORY_SEPARATOR . 'admin');
//
Yii::setAlias('commonFolder', '');
