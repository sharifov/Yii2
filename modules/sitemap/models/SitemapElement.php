<?php

namespace thread\modules\sitemap\models;

use Yii;

/**
 * Class SitemapElement
 *
 * @package app\modules\sitemap\models;
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class SitemapElement extends \thread\models\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function getDb() {
        return \thread\modules\sitemap\Sitemap::getDb();
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%seo_sitemap_element}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['module_id', 'model_id', 'key', 'url'], 'required'],
//            [['url'], 'url'],
            [['url'], 'string', 'max' => 2048],
            [['create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['module_id', 'model_id'], 'string', 'max' => 255],
            [['key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return [
            'default' => ['module_id', 'model_id', 'key', 'url'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'module_id' => Yii::t('app', 'module'),
            'model_id' => Yii::t('app', 'model'),
            'key' => Yii::t('app', 'key'),
            'url' => Yii::t('app', 'link'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

}
