<?php

namespace thread\components;

use thread\components\MultiLanguage;

/**
 * Class Request
 * 
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
final class Request extends \yii\web\Request {

    private $_requestUri;

    /**
     *
     * @return string
     */
    protected function resolveRequestUri() {
        if ($this->_requestUri === null) {
            $this->_requestUri = MultiLanguage::processLangInUrl(parent::resolveRequestUri());
        }
        return $this->_requestUri;
    }

    /**
     *
     * @return string
     */
    public function getOriginalUrl() {
        return $this->getOriginalRequestUri();
    }

    /**
     *
     * @return string
     */
    public function getOriginalRequestUri() {
        return MultiLanguage::addLangToUrl($this->resolveRequestUri());
    }

}
