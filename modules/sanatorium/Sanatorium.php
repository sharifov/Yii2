<?php

namespace thread\modules\sanatorium;

use Yii;

/**
 * Class Sanatorium
 *
 * @package thread\modules\sanatorium
 */
class Sanatorium extends \thread\base\Module
{
    public $name = 'sanatorium';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb()
    {
        return Yii::$app->get('db');
    }
}
