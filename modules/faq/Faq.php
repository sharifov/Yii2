<?php

namespace thread\modules\faq;

use Yii;

/**
 * Class Faq
 *
 * @package thread\modules\faq
 */
class Faq extends \thread\base\Module
{
    public $name = 'faq';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb()
    {
        return Yii::$app->get('db');
    }
}
