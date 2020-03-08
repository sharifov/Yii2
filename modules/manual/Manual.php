<?php

namespace thread\modules\manual;

use Yii;

/**
 * Class News
 *
 * @package thread\modules\news
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Manual extends \thread\base\Module {

    public $name = 'manual';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb() {
        return Yii::$app->get('db');
    }

}
