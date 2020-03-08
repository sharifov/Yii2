<?php

namespace thread\modules\sanatorium\models;

use thread\modules\manual\models\Rooms;
use Yii;

/**
 * Class DatePrice
 * @package thread\modules\sanatorium\models
 */
class DatePrice extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_dates_price}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['begin_date', 'end_date'], 'required'],
            [
                ['published', 'deleted'],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [
                [
                    'create_time',
                    'update_time',
                    'sanatorium_id',
                ],
                'integer'
            ],
            [['begin_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'begin_date' => Yii::t('app', 'begin_date'),
            'end_date' => Yii::t('app', 'end_date'),
            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
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
                'begin_date',
                'end_date',
                'published',
            ],
        ];
    }

    /**
     *   (Вид номеров)
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasOne(Rooms::class, ['id' => 'manual_room_id']);
    }

    /**
     *  Тип номера санатория!
     * @return \yii\db\ActiveQuery
     */
    public function getSanRoomType()
    {
        return $this->hasOne(Roomtype::class, ['id' => 'sanatorium_room_type_id']);
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
     * @param $dateBegin
     * @param $dateEnd
     * @return mixed
     */
    public static function findByDates($sanatorium_id, $dateBegin, $dateEnd)
    {
        return self::find_base()
            ->andWhere([
                'sanatorium_id' => $sanatorium_id
            ])
            ->andWhere(
                ['AND',
                    ['<=', 'begin_date', $dateBegin],
                    ['>=', 'end_date', $dateEnd],
                ]
            )->undeleted()
            ->one();

//            ->andWhere('(begin_date <= :dateFrom && :dateFrom <= end_date) AND (begin_date <= :dateTo && :dateTo <= end_date)')
    }

}
