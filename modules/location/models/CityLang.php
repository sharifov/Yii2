<?php

namespace thread\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Class CountryLang
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

class CityLang extends \thread\models\ActiveRecordLang {


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
        return '{{%location_city_lang}}';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return  [
//            [['title'], 'required'],
//            ['rid', 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
//            [['title'], 'string', 'max' => 255],
//        ];
//    }


    public function rules() {
        return [
            [['rid'], 'required'],
            ['rid', 'integer'],
            ['rid', 'exist', 'targetClass' => City::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            ['title', 'string', 'max' => 1000],
            [['areasTreatmentMain','areasTreatmentSecondary'], 'string', 'max' => 2000],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'areasTreatmentMain' => Yii::t('app', 'areasTreatmentMain'),
            'areasTreatmentSecondary' => Yii::t('app', 'areasTreatmentSecondary'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'meta_desc' => Yii::t('app', 'meta_desc'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_h1' => Yii::t('app', 'meta_h1')
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
                'meta_h1',
                'areasTreatmentMain',
                'areasTreatmentSecondary',
            ],
        ];
    }

}
