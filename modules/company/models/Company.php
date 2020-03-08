<?php

namespace thread\modules\company\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\modules\user\models\User;
use admin\modules\location\models\Country;
use thread\modules\sanatorium\models\Sanatoriums;

/**
 * Class Company
 *
 * @package thread\modules\company\models
 */
class Company extends \thread\models\ActiveRecord
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
        return '{{%company}}';
    }


    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['country_id', 'city_id', 'create_time', 'update_time'], 'integer'],
            [['image_link', 'phone', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
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
            'backend' => [ 'country_id', 'city_id', 'image_link', 'phone', 'email', 'published', 'deleted'],
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
            'city_id' => Yii::t('company', 'City'),
            'image_link' => Yii::t('app', 'image_link'),
            'phone' => Yii::t('company', 'Phone'),
            'email' => Yii::t('company', 'Email'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),

            'count_sanatoriums' => Yii::t('app', 'count_sanatoriums'),
            'country_id' => Yii::t('app', 'country_id'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->undeleted();
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Country::class, ['id' => 'city_id'])->undeleted();
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CompanyLang::class, ['rid' => 'id']);
    }


    /**
     *
     * @return string
     */
    public function getImageLinkUrl()
    {
        return Yii::$app->modules['company']->getImageBaseUrl() . '/' . $this->image_link;
    }

    /**
     *
     * @return ActiveQuery
     */

    public static function dropDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'lang.title');
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getSanatoriums()
    {
        return $this->hasMany(Sanatoriums::class, ['company_id' => 'id']);
    }

}
