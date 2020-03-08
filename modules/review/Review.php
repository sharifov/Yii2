<?php

namespace thread\modules\review;

use Yii;

/**
 * Class Review
 *
 * @package thread\modules\review
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Review extends \thread\base\Module {

    public $title = "Review";
    public $name = 'review';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb() {
        return Yii::$app->get('db');
    }

}
