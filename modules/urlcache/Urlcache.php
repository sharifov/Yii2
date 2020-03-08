<?php

namespace thread\modules\urlcache;

use Yii;

/**
 * Class CompanyModule
 *
 * @package thread\modules\company
 */
class Urlcache extends \thread\base\Module
{
    public $name = 'company';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb()
    {
        return Yii::$app->get('coredb');
    }

}
