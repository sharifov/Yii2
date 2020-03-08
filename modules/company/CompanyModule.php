<?php

namespace thread\modules\company;

use Yii;

/**
 * Class CompanyModule
 *
 * @package thread\modules\company
 */
class CompanyModule extends \thread\base\Module
{
    public $name = 'company';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb()
    {
        return Yii::$app->get('coredb');
    }

    /**
     *
     * @return string
     */
    public function getImageBasePath()
    {
        return Yii::getAlias('@web-frontend-upload') . '/company';
    }

    /**
     *
     * @return string
     */
    public function getImageBaseUrl()
    {
        return $this->fileUploadFolder;
    }
}
