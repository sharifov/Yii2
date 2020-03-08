<?php

namespace thread\widgets\form\select2;

use yii\web\AssetBundle;

/**
 * @package thread\widgets\form\select2
 * @author Filament
 * @copyright (c) 2015, Thread
 * @version 07/02/2015
 */
class BootstrapAsset extends AssetBundle {

    public $sourcePath = '@bower/select2';
    public $css = [
        'select2-bootstrap.css'
    ];
    public $depends = [
        \thread\widgets\form\select2\Asset::class,
        \yii\bootstrap\BootstrapAsset::class,
    ];

}
