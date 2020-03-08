<?php

namespace thread\modules\company\models;

use thread\modules\location\models\Currency;
use Yii;

/**
 * Class Transferorders
 * @package thread\modules\company\models
 */
class Transferorders extends \thread\models\ActiveRecord
{

    const STATUS_BOOKED = 'booked';
    const STATUS_CANCELLED = 'cancelled';


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
        return '{{%company_transfer_orders}}';
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['transfer_id', 'number_persons', 'email', 'phone', 'name_surname', 'address'], 'required'],
            [['back_transfer', 'published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => array_keys(Transfer::typeKeyRange())],
            [['status'], 'default', 'value' => self::STATUS_BOOKED],
            [['cancellation_date'], 'default', 'value' => 0],
            [['transfer_id', 'currency_id', 'number_persons', 'cancellation_date', 'create_time', 'update_time', 'token'], 'integer'],
            [
                [
                    'flight_number_p1',
                    'flight_number_p2',
                    'arrival_date_p1',
                    'arrival_date_p2',
                    'arrival_time_p1',
                    'arrival_time_p2',
                    'email',
                    'phone',
                    'name_surname',
                    'address',
                    'status'
                ],
                'string',
                'max' => 255
            ],
            [['comment'], 'string', 'max' => 512],
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
            'backend' => [
                'transfer_id',
                'back_transfer',
                'flight_number_p1',
                'flight_number_p2',
                'arrival_date_p1',
                'arrival_date_p2',
                'arrival_time_p1',
                'arrival_time_p2',
                'number_persons',
                'email',
                'phone',
                'name_surname',
                'type',
                'comment',
                'address',
                'published',
                'deleted',
                'token',
                'cancellation_date',
                'status',
                'currency_id'
            ],
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
            'transfer_id' => Yii::t('app', 'Transfer'),
            'flight_number_p1' => Yii::t('company', 'flight_number'),
            'flight_number_p2' => Yii::t('company', 'flight_number'),
            'arrival_date_p1' => Yii::t('company', 'arrival_date'),
            'arrival_date_p2' => Yii::t('app', 'Departure date'),
            'arrival_time_p1' => Yii::t('company', 'arrival_time'),
            'arrival_time_p2' => Yii::t('app', 'Departure time'),
            'number_persons' => Yii::t('company', 'number_persons'),
            'email' => Yii::t('company', 'email'),
            'phone' => Yii::t('company', 'phone'),
            'name_surname' => Yii::t('company', 'name_surname'),
            'type' => Yii::t('company', 'type_transfer'),
            'comment' => Yii::t('company', 'comment'),
            'address' => Yii::t('company', 'address'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'first-transfer' => Yii::t('app', 'first-transfer'),
            'second-transfer' => Yii::t('app', 'second-transfer'),
            'back_transfer' => Yii::t('app', 'Back transfer'),
            'token' => Yii::t('app', 'token'),
            'status' => Yii::t('app', 'status'),
            'cancellation_date' => Yii::t('app', 'cancellation_date'),
            'currency_id' => Yii::t('app', 'currency_id'),
            'price' => Yii::t('app', 'Price'),
            'itinerary' => Yii::t('app', 'itinerary'),
            'country' => Yii::t('app', 'country_id'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransfer()
    {
        return $this->hasOne(Transfer::class, ['id' => 'transfer_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }


    /**
     * Полный трансферный путь
     */

    public function getFullTransferPath()
    {
        $transferFrom = (isset($this->transfer->startTransferPoint->lang)) ? $this->transfer->startTransferPoint->lang->title : '';
        $transferTo = (isset($this->transfer->endTransferPoint->lang)) ? $this->transfer->endTransferPoint->lang->title : '';

        return $transferFrom . ' в ' . $transferTo;
    }


    /**
     * Полный трансферный путь
     */

    public function getFullBackTransferPath()
    {
        $transferFrom = (isset($this->transfer->startTransferPoint->lang)) ? $this->transfer->startTransferPoint->lang->title : '';
        $transferTo = (isset($this->transfer->endTransferPoint->lang)) ? $this->transfer->endTransferPoint->lang->title : '';

        return $transferTo . ' - ' . $transferFrom;
    }


    /**
     *
     * @return boolean
     */

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->token = sha1(uniqid() . time() . 'Пони тоже кони');
        }
        return parent::beforeSave($insert);
    }

}
