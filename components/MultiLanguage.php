<?php

namespace thread\components;

use Yii;
use yii\helpers\StringHelper;
use thread\models\Lang;

/**
 * Class MultiLanguage
 *
 * @package thread\components
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
final class MultiLanguage {

    const MULTI = 1;
    const SHOW_DEFAULT = 0;
    const KEY_ON = 1;
    const KEY_OFF = 0;

    protected static $domains;
    protected static $baseFolder = '';
    protected static $homeUrl = '';

    /**
     *
     * @param string $url
     * @return self
     */
    protected static function setDomains($url) {
        self::$baseFolder = '';

        if (empty(self::$homeUrl)) {
            self::$homeUrl = rtrim(StringHelper::dirname($_SERVER['PHP_SELF']), '/');
        }

        if (empty(self::$baseFolder)) {
            if ($str = mb_stristr(self::$homeUrl, 'frontend', TRUE)) {
                self::$baseFolder = $str;
            } elseif ($str = mb_stristr(self::$homeUrl, 'backend', TRUE)) {
                self::$baseFolder = $str . "backend";
            } elseif ($str = mb_stristr(self::$homeUrl, 'admin', TRUE)) {
                self::$baseFolder = $str . "admin";
            } elseif ($str = mb_stristr(self::$homeUrl, 'admin', TRUE)) {
                self::$baseFolder = $str . "admin";
            }

            if ($str == false && !empty(self::$homeUrl)) {
                self::$baseFolder = rtrim(self::$homeUrl, '/');
            }

            self::$baseFolder = rtrim(self::$baseFolder, '/');
        }

        $url = StringHelper::byteSubstr($url, StringHelper::byteLength(self::$baseFolder), StringHelper::byteLength($url));

        self::$domains = explode('/', ltrim($url, '/'));
        return self::$domains;
    }

    /**
     *
     * @param string $url
     * @return string
     */
    public static function processLangInUrl($url) {

        if (self::MULTI) {
            $domains = self::setDomains($url);
            $exists = (isset($domains[0])) ? Lang::isExists($domains[0]) : false;
            $_def = Lang::getDefaultLang();
            $isDefault = ($_def->alias == $domains[0]) ? true : false;

            if ($exists && !$isDefault) {
                $lang = Lang::getLangByAlias($domains[0]);
                Yii::$app->language = $lang['local'];
                array_shift($domains);
            } elseif ($isDefault && self::SHOW_DEFAULT) {
                array_shift($domains);
            }

            $d = (!empty($domains)) ? '/' . implode('/', $domains) : '';

            return self::$homeUrl . $d;
        } else {
            return $url;
        }
    }

    /**
     *
     * @param string $url
     * @return string
     */
    public static function addLangToUrl($url) {
        if (self::MULTI) {
            $domains = self::setDomains($url);
//            if ($domains[0] == 'frontend') {
//                array_shift($domains);
//            }

            $exists = (isset($domains[0])) ? Lang::isExists($domains[0]) : false;
            $_def = Lang::getDefaultLang();
            $isDefault = (Yii::$app->language === $_def->local) ? true : false;

            if ($exists && $isDefault && self::SHOW_DEFAULT == self::KEY_OFF) {
                array_shift($domains);
            }

            if (!$exists && !$isDefault) {
                $lang = Lang::getLangByLocal(Yii::$app->language);
                array_unshift($domains, $lang->alias);
            }
            $d = (!empty($domains)) ? '/' . implode('/', $domains) : '';

            return self::$baseFolder . $d;
        } else {
            return $url;
        }
    }

    /**
     *
     * @return string
     */
    public static function getBaseUrl() {
        return self::$baseFolder;
    }

}
