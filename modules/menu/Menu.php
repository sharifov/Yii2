<?php

namespace thread\modules\menu;

use Yii;

/**
 * Class Menu
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Menu extends \thread\base\Module {

    public $name = 'menu';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb() {
        return Yii::$app->get('coredb');
    }

}
