<?php

namespace thread\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Article
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Article extends \thread\models\ActiveRecord {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\news\News::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%news_article}}';
    }

    /**
     * 
     * @return array
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'transliterate' => [
                        'class' => TransliterateBehavior::class,
                        'attributes' => [
                            \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['alias' => 'alias'],
                            \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['alias' => 'alias']
                        ]
                    ],
        ]);
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['alias'],'required'],
             [['country_id', 'create_time', 'update_time','position'], 'integer'],
             [['city_id', 'create_time', 'update_time','position'], 'integer'],
            [['is_country','published', 'deleted', 'is_main'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'image_link','meta_title','meta_description','meta_keywords'], 'string', 'max' => 255],
            [['alias'], 'unique']
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
            'backend' => ['country_id','is_country','city_id', 'alias', 'is_main', 'image_link', 'position', 'published', 'deleted',],
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'image_link' => Yii::t('app', 'image_link'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    /**
     *
     * @return ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(ArticleLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getPublishedTime() {
        $format = Yii::$app->modules['news']->params['format']['date'];
        return ($this->published_time == 0) ? date($format) : date($format, $this->published_time);
    }

    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getPublishedTimeISO() {
        return date('Y-m-d\TH:i:sO', $this->published_time);
    }

}
