<?php

namespace thread\modules\widgetsetting;

use Yii;

/**
 * Class Widgetsetting
 *
 * @package thread\modules\widgetsetting
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

class Widgetsetting extends \thread\base\Module {

    public $name = 'widgetsetting';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     *
     * @return string
     */
    public static function getDb() {
        return Yii::$app->get('db');
    }


}
