<?php

namespace thread\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Language
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Language extends \thread\models\ActiveRecord {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\location\Location::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%location_language}}';
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
            [['alias'], 'required'],
            [['create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'title'], 'string', 'max' => 50],
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
            'backend' => ['alias', 'title', 'published', 'deleted'],
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
            'title' => Yii::t('app', 'title'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

}
