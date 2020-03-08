<?php

namespace thread\modules\company\models;

use Yii;
use yii\helpers\ArrayHelper;
use admin\modules\location\models\Country;

/**
 * Class Company
 *
 * @package thread\modules\company\models
 */
class Transfercompany extends \thread\models\ActiveRecord
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
        return '{{%company_transfer_company}}';
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['country_id', 'city_id','currency_id', 'create_time', 'update_time'], 'integer'],
            [['image_link', 'address_www_booking', 'phone', 'email'], 'string', 'max' => 255],
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
            'backend' => ['address_www_booking', 'country_id','currency_id', 'city_id', 'image_link', 'phone', 'email', 'published', 'deleted'],
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
            'country_id' => Yii::t('company', 'Country'),
            'city_id' => Yii::t('company', 'City'),
            'image_link' => Yii::t('app', 'image_link'),
            'phone' => Yii::t('company', 'Phone'),
            'email' => Yii::t('company', 'Email'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'Transfers' => Yii::t('company', 'Transfers'),
            'Transferpoints' => Yii::t('app', 'Transferpoints'),
            'address_www_booking' => Yii::t('company', 'address_www_booking')
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
    public function getLang()
    {
        return $this->hasOne(TransfercompanyLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getTransfer()
    {
        return $this->hasMany(Transfer::class, ['transfer_company_id' => 'id']);
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getTransferpoints()
    {
        return $this->hasMany(Transferpoints::class, ['country_id' => 'country_id']);
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

}
