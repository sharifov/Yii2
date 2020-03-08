<?php

namespace thread\modules\company\models;

use Yii;
use thread\modules\location\models\Country;

/**
 * Class Transferpoints
 *
 * @package thread\modules\company\models
 */
class Transferpoints extends \thread\models\ActiveRecord
{
    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\company\CompanyModule::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%company_transfer_points}}';
    }


    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['published', 'deleted','is_airport'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['country_id', 'create_time', 'update_time'], 'integer'],
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['country_id', 'published', 'deleted', 'is_airport'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'country_id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'is_airport' => "Airport"
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(TransferpointsLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

}
