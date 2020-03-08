<?php

namespace thread\modules\sanatorium\models;

use thread\modules\location\models\Country;
use Yii;

/**
 * Class Comment
 * @package thread\modules\sanatorium\models
 */
class Comment extends \thread\models\ActiveRecord
{

    const STATUS_REQUEST_SENT = 'sent';
    const STATUS_REQUEST_VIEWED = 'viewed';
    const STATUS_REQUEST_COMPLETED = 'completed';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_comments}}';
    }


    public function rules()
    {
        return [
            [
                [
                    'sanatorium_id',
                    'quality',
                    'quality_accommodation',
                    'quality_food',
                    'quality_staff',
                    'location',
//                    'positive_review',
//                    'negative_review',
                ],
                'required'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['quality', 'quality_accommodation', 'quality_food', 'quality_staff', 'location'], 'double'],
            [['country_id'], 'integer'],
            [['user_id', 'booking_id','professionalism_doctor'], 'safe'],
            [['user_id'], 'default', 'value' => 0],
            [['positive_review', 'negative_review'], 'string', 'max' => 10000],
            [['surname', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'sanatorium_id' => Yii::t('app', 'Sanatorium'),
            'quality' => Yii::t('app', 'Quality of treatment'),
            'quality_accommodation' => Yii::t('app', 'quality_accommodation'),
            'quality_food' => Yii::t('app', 'quality_food'),
            'quality_staff' => Yii::t('app', 'quality_staff'),
            'location' => Yii::t('app', 'location'),
            'positive_review' => Yii::t('app', 'positive_review'),
            'negative_review' => Yii::t('app', 'negative_review'),
            'user_id' => Yii::t('app', 'user_id'),
            'booking_id' => Yii::t('app', 'booking_id'),
            'status' => Yii::t('app', 'Status'),

            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'name' => Yii::t('app', 'name'),
            'surname' => Yii::t('app', 'surname'),
            'country_id' => Yii::t('app', 'country_id'),
            'professionalism_doctor' => Yii::t('app', 'professionalism_doctor'),
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
                'sanatorium_id',
                'quality',
                'quality_accommodation',
                'quality_food',
                'quality_staff',
                'location',
                'positive_review',
                'negative_review',
                'user_id',
                'name',
                'surname',
                'country_id',
                'professionalism_doctor',

                'published',
            ],
        ];
    }

    /**
     *   Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    /**
     * Relation to booking table
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(Booking::className(), ['id' => 'booking_id']);
    }


    /**
     * Relation to booking table
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * Жульничаем) Получаем имя пользователя
     * @return \yii\db\ActiveQuery
     */
    public function getFullName()
    {
        return (isset($this->booking))
            ? $this->booking->getFullName()
            : $this->name . ' ' . $this->surname;
    }

    /**
     *
     * @return string
     */
    public function getCreateTime()
    {
        $format = Yii::$app->getModule('sanatorium')->params['format']['date'];
        return ($this->create_time == 0) ? date($format) : date($format, $this->create_time);
    }

    /**
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::STATUS_REQUEST_SENT => Yii::t('sanatorium', 'Request sent'),
            self::STATUS_REQUEST_VIEWED => Yii::t('sanatorium', 'Request viewed'),
            self::STATUS_REQUEST_COMPLETED => Yii::t('sanatorium', 'Request completed'),
        ];
    }

    public static function findCurrentComment($hash)
    {
        return self::find()
            ->where(['hash' => $hash])
            ->andWhere(['!=', 'status', self::STATUS_REQUEST_COMPLETED])
            ->one();
    }
}
