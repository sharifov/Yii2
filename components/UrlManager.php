<?php

namespace thread\components;

use thread\components\MultiLanguage;

/**
 * Class UrlManager
 * 
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
final class UrlManager extends \yii\web\UrlManager {

    /**
     * 
     * @param array $params
     * @return string
     */
    public function createUrl($params) {
        return MultiLanguage::addLangToUrl(parent::createUrl($params));
    }

    /**
     * 
     * @return string
     */
    public function getBaseUrl() {
        $this->setBaseUrl(MultiLanguage::getBaseUrl());
        return parent::getBaseUrl();
    }

}
