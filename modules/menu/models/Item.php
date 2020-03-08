<?php

namespace thread\modules\menu\models;

use Yii;

/**
 * Class Item
 *
 * @package thread\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Item extends \thread\models\ActiveRecord {

    protected static $sources = [
        'page' => \frontend\modules\page\models\Page::class,
    ];

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\menu\Menu::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%menu_item}}';
    }

    /**
     * @return array
     */
    public function rules() {
        return [
            [['group_id, type'], 'required'],
            [['create_time', 'update_time', 'group', 'position', 'group_id', 'parent_id' ], 'integer'],
            //
            [['type'], 'in', 'range' => array_keys(static::typeRange())],
            ['type', 'default', 'value' => array_keys(static::typeRange())[0]],
            //
            [['link_type'], 'in', 'range' => array_keys(static::linkTypeRange())],
            ['link_type', 'default', 'value' => array_keys(static::linkTypeRange())[0]],
            //
            [['link_target'], 'in', 'range' => array_keys(static::linkTargetRange())],
            ['link_target', 'default', 'value' => array_keys(static::linkTargetRange())[0]],
            //
            ['internal_source', 'default', 'value' => ['page']],
            //
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['link', 'internal_source'], 'string', 'max' => 255],
            //default
            [['type'], 'default', 'value' => 'normal'],
            [['position', 'parent_id'], 'default', 'value' => '0']
        ];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'order' => ['position'],
            'backend' => ['link', 'group_id', 'type', 'published', 'deleted', 'position', 'internal_source_id', 'link_target', 'link_type', 'parent_id'],
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'group_id' => Yii::t('menu', 'Menu'),
            'type' => Yii::t('menu', 'type'),
            'link' => Yii::t('app', 'link'),
            'link_type' => Yii::t('menu', 'link_type'),
            'link_target' => Yii::t('menu', 'link_target'),
            'internal_source' => Yii::t('menu', 'internal_source'),
            'internal_source_id' => Yii::t('menu', 'internal_source_id'),
            'position' => Yii::t('app', 'position'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'parent_id' => Yii::t('app', 'parent_id'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getMenu() {
        return $this->hasOne(Menu::class, ['id' => 'group_id'])->undeleted();
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(ItemLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(Item::class, ['parent_id' => 'id'])->undeleted();
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getSource() {
        return $this->hasOne(self::$sources[$this->internal_source], ['id' => 'internal_source_id']);
    }

    /**
     * Варіанти типів елементів меню
     * Значення параметра type
     * @return array
     */
    public static function typeRange() {
        return [
            'normal' => Yii::t('menu', 't_normal'),
            'divider' => Yii::t('menu', 't_divider'),
            'header' => Yii::t('menu', 't_header'),
        ];
    }

    /**
     * Варіанти типів посилань елементів
     * Значення параметра link_type
     * @return array
     */
    public static function linkTypeRange() {
        return [
            'external' => Yii::t('menu', 'lt_external'),
            'internal' => Yii::t('menu', 'lt_internal'),
        ];
    }

    /**
     * Варіанти типів відкриття посилань посилань елементів
     * Значення параметра link_type
     * @return array
     */
    public static function linkTargetRange() {
        return [
            '_blank' => Yii::t('menu', 'lt_blank'),
            '_self' => Yii::t('menu', 'lt_self'),
        ];
    }

}
