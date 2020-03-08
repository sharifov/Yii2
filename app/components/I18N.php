<?php

namespace thread\app\components;

/**
 * Class I18N
 * 
 * @package thread\app\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class I18N extends \yii\i18n\I18N {

    public function translate($category, $message, $params, $language) {
        return parent::translate($category, $message, $params, \Yii::$app->params['themes']['language']);
    }

}
