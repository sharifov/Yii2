<?php

namespace thread\widgets\form\select2;

use yii\web\AssetBundle;

/**
 * @package thread\widgets\form\select2
 * @author Filament
 * @copyright (c) 2015, Thread
 * @version 07/02/2015
 */
class Select2Asset extends AssetBundle {

    public $sourcePath = '@bower/select2';
    public $css = [
        'select2.css'
    ];
    public $depends = [
        \thread\widgets\form\select2\Asset::class
    ];

}
