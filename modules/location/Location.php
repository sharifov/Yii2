<?php

namespace thread\modules\location;

use Yii;

/**
 * Class Location
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Location extends \thread\base\Module {

    public $name = 'location';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    public static function getDb() {
        return Yii::$app->get('coredb');
    }

}
