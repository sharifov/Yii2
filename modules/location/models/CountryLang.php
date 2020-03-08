<?php

namespace thread\modules\location\models;

use Yii;

/**
 * Class CountryLang
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class CountryLang extends \thread\models\ActiveRecordLang {

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
        return '{{%location_country_lang}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['rid', 'lang', 'title'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => Country::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            ['title', 'string', 'max' => 1000],
            [['rid', 'lang'], 'unique', 'targetAttribute' => ['rid', 'lang'], 'message' => 'The combination of rid and lang has already been taken.']
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'meta_desc' => Yii::t('app', 'meta_desc'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_h1' => Yii::t('app', 'meta_h1'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => [
                'title',
                'meta_title',
                'meta_desc',
                'meta_keywords',
                'meta_h1'
            ],
        ];
    }

}
