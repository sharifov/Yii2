<?php

namespace thread\widgets\form\select2;

use yii\web\AssetBundle;

/**
 * Class Asset
 * @package thread\widgets\form\select2
 * @author Filament
 * @copyright (c) 2015, Thread
 * @version 07/02/2015
 */
class Asset extends AssetBundle {

    public $language;
    public $sourcePath = '@bower/select2';
    public $js = [
        'select2.js'
    ];
    public $css = [
        'select2.css',
    ];
    public $depends = [
        \yii\web\JqueryAsset::class
    ];

    public function registerAssetFiles($view) {
        if ($this->language !== null) {
            $this->js[] = 'select2_locale_' . $this->language . '.js';
        }
        parent::registerAssetFiles($view);
    }

}
