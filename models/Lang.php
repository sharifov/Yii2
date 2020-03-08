<?php

namespace thread\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class Lang
 *
 * @package thread\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
final class Lang extends \thread\models\ActiveRecord {

    /**
     *
     * @return string
     */
    public static function getDb() {
        return Yii::$app->get('coredb');
    }

    /**
     * Поточна мова
     * @var typeof Lang
     */
    protected static $current_lang = NULL;

    /**
     * Мова за замовчуванням
     * @var typeof Lang
     */
    protected static $default_lang = NULL;

    /**
     * Перелік доступних мов
     * @var typeof Lang
     */
    protected static $list = NULL;

    /**
     * @return string
     */
    public static function tableName() {
        return '{{%language}}';
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            [['alias', 'local', 'title'], 'required'],
            [['published', 'deleted'], 'in', 'range' => self::statusKeyRange()],
            [['update_time', 'create_time'], 'integer'],
            [['alias'], 'string', 'min' => 2, 'max' => 2],
            [['local'], 'string', 'max' => 5],
            [['title'], 'string', 'max' => 50],
            [['alias'], 'unique']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'alias'),
            'local' => Yii::t('app', 'local'),
            'title' => Yii::t('app', 'title'),
            'default' => Yii::t('app', 'default'),
            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'backend' => ['alias', 'local', 'title', 'default', 'published'],
        ];
    }

    /**
     * 
     * @return ActiveQuery
     */
    public static function find_base() {
        return static::find()->undeleted();
    }

    /**
     * 
     * @return ActiveDataProvider
     */
    public function search() {
        $query = self::find_base();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 99
            ]
        ]);

        return $dataProvider;
    }

    /**
     * Повертає вказівник на поточний обєкт мови
     * @return Lang
     */
    static function getCurrent() {
        if (self::$current_lang === NULL) {
            self::setCurrentByLocal(Yii::$app->language);
        }
        return self::$current_lang;
    }

    /**
     * Встановлення поточного обєкту мови та локаль користувача за $alias
     * @param string $alias
     */
    static function setCurrentByAlias($alias = NULL) {
        $language = self::getLangByAlias($alias);
        self::$current_lang = ($language === NULL) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current_lang->local;
    }

    /**
     * Встановлення поточного обєкту мови та локаль користувача за $local
     * @param string $local
     */
    static function setCurrentByLocal($local = NULL) {
        $language = self::getLangByLocal($local);
        self::$current_lang = ($language === NULL) ? self::getDefaultLang() : $language;
        Yii::$app->language = self::$current_lang->local;
    }

    /**
     * Повертає обєкт мови за замовчуванням
     * @return Lang
     */
    static function getDefaultLang() {
        if (self::$default_lang === NULL) {
            if (self::$list == NULL) {
                self::getList();
            }
            foreach (self::$list as $data) {
                if ($data->default == static::STATUS_KEY_ON) {
                    self::$default_lang = $data;
                    break;
                }
            }
        }
        return self::$default_lang;
    }

    /**
     * Повертає перелік мов
     * @return array Lang
     */
    static function getList() {
        if (self::$list === NULL) {

            $list_all = Lang::find()->published()->all();
            $l = array();
            foreach ($list_all as $data) {
                $l[$data->alias] = $data;
            }

            self::$list = $l;
        }
        return self::$list;
    }

    /**
     * Повертає обєкт мови за ідентифікатором
     * @param string $alias
     * @return Lang|null
     */
    static function getLangByAlias($alias = NULL) {
        if ($alias === NULL) {
            return NULL;
        } else {
            if (self::$list == NULL) {
                self::getList();
            }
            return (isset(self::$list[$alias])) ? self::$list[$alias] : NULL;
        }
    }

    /**
     * Повертає обєкт мови за ідентифікатором
     * @param string $local
     * @return Lang|null
     */
    static function getLangByLocal($local = NULL) {
        if ($local === NULL) {
            return NULL;
        } else {
            if (self::$list == NULL) {
                self::getList();
            }
            $return = NULL;
            foreach (self::$list as $lang) {
                if ($lang->local === $local) {
                    $return = $lang;
                    break;
                }
            }
            return $return;
        }
    }

    /**
     * Перевірка мови на наявність
     * @param string $alias
     * @return boolean
     */
    static function isExists($alias = NULL) {
        if ($alias === NULL) {
            return FALSE;
        } else {
            if (self::$list == NULL) {
                self::getList();
            }
            return (isset(self::$list[$alias])) ? TRUE : FALSE;
        }
    }

}
