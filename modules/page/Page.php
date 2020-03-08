<?php

namespace thread\modules\page;

use Yii;

/**
 * Class Page
 *
 * @package thread\modules\page
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Page extends \thread\base\Module {

    public $name = 'page';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb() {
        return Yii::$app->get('coredb');
    }

    /**
     *
     * @return string
     */
    public function getImageBasePath() {
        return Yii::getAlias('@web-frontend-upload') . '/page';
    }

    /**
     *
     * @return string
     */
    public function getImageBaseUrl() {
        return '/cms2/' . $this->fileUploadFolder;
    }

}
