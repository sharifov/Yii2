<?php

namespace thread\modules\sanatorium\models;

use frontend\components\Selection;
use thread\modules\location\models\Currency;
use Yii;

class Booking extends \thread\models\ActiveRecord
{
    const COMMENT_TYPE_BAD = [
//        0 => 'Не выбрано',
        1 => 'Не важно',
        2 => 'Две односпальные',
        3 => 'Одна двухспальная',
    ];

    /**
     * Статусы бронирования
     */

    const STATUS_BOOKED = 'booked';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_ADD_MANAGER_ONE_ROOM = 'add-manager_one_room';
    const STATUS_ADD_MANAGER_ALL_ROOMS = 'add-manager_all_rooms';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_booking}}';
    }


    public function rules()
    {
        return [
            [
                [
//                    'card_number',
//                    'card_name',
//                    'card_type',
                    'sanatorium_id',
                    'number_rooms',
                    'number_guests',
                    'email',
                    'date_begin',
                    'date_end',
                    'phone',
                    'end_date',
//                    'card_year',
//                    'card_month',
                ],
                'required', 'message'=>'odduba'
            ],
            [['card_number', 'card_name', 'card_type', 'card_year', 'card_month'], 'required', 'on' => 'frontendWithCard'],

            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'create_time',
                    'update_time',
                    'number_days',
                    'number_guests',
                    'number_rooms',
                    'sanatorium_id',
                    'card_year',
                    'card_month',
                    'comment_type_bed',
                    'comment_baby_bed',
                    'priceDefault',
                    'currency_id',
                    'cancellation_date',
                    'position_grid'
                ],
                'integer'
            ],
            [['token', 'email', 'comment', 'status', 'card_name', 'name', 'surname'], 'string', 'max' => 255],
            [['phone', 'card_number'], 'string', 'max' => 100],
            [['order_number', 'token'], 'unique'],
            [['email'], 'email'],
            [['status'], 'default', 'value' => self::STATUS_BOOKED],
            [
                [
                    'comment_type_bed',
                    'cancellation_date',
                    'comment_baby_bed',
                    'country_id',
                    'currency_id',
                    'position_grid'
                ],
                'default', 'value' => 0
            ],
//            [['begin_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],
//            [['date_begin', 'date_end'], 'date'],
            [
                ['total_price_basic', 'total_price_user', 'total_price_basic_discount', 'total_price_user_discount', 'total_price_sanatorium', 'total_price_sanatorium_discount'],
                'number',
                'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
//            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'token' => Yii::t('app', 'token'),
            'email' => Yii::t('app', 'email'),
            'phone' => Yii::t('app', 'contact_phone'),
            'total_price_basic' => Yii::t('app', 'total_price_basic'),
            'total_price_user' => Yii::t('app', 'total_price_user'),
            'date_begin' => Yii::t('app', 'date_begin'),
            'date_end' => Yii::t('app', 'date_end'),
            'number_rooms' => Yii::t('app', 'number_rooms'),
            'number_guests' => Yii::t('app', 'number_guests'),
            'number_days' => Yii::t('app', 'number_days'),
            'card_number' => Yii::t('app', 'card_number'),
            'card_type' => Yii::t('app', 'card_type'),
            'card_name' => Yii::t('app', 'card_name'),
            'card_year' => Yii::t('app', 'card_year'),
            'card_month' => Yii::t('app', 'card_month'),
            'comment_type_bed' => Yii::t('app', 'comment_type_bed'),
            'comment' => Yii::t('app', 'comment'),
            'comment_baby_bed' => Yii::t('app', 'comment_baby_bed'),
            'name' => Yii::t('app', 'name'),
            'surname' => Yii::t('app', 'surname'),
            'country_id' => Yii::t('app', 'country_id'),
            'sanatorium_id' => Yii::t('app', 'Sanatorium'),
            'Customers' => Yii::t('app', 'Customers'),
            'NumberRooms' => Yii::t('app', 'NumberRooms'),
            'currency_id' => Yii::t('app', 'currency_id'),
            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'status' => Yii::t('app', 'status'),
            'position_grid' => Yii::t('app', 'position_grid'),
            'cancellation_date' => Yii::t('app', 'cancellation_date'),
            'total_price_basic_discount' => Yii::t('app', 'total_price_basic_discount'),
            'total_price_user_discount' => Yii::t('app', 'total_price_user_discount')
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
            'position_grid' => ['position_grid'],
            'cancel' => ['status', 'cancellation_date'],
            'backend' => [
                'sanatorium_id',
                'token',
                'email',
                'phone',
                'total_price_basic',
                'total_price_user',
                'date_begin',
                'date_end',
                'number_rooms',
                'number_guests',
                'number_days',
                'card_number',
                'card_type',
                'card_name',
                'card_year',
                'card_month',
                'comment_type_bed',
                'comment',
                'comment_baby_bed',
                'name',
                'surname',
                'currency_id',
                'published',
                'status',
                'cancellation_date',
                'country_id',
                'currency_id',
                'total_price_user_discount',
                'total_price_basic_discount',
                'total_price_sanatorium',
                'total_price_sanatorium_discount',
                'position_grid',
            ],
        ];
    }

    /**
     *   Валюта
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
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
     *   Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(BookingUser::class, ['sanatorium_booking_id' => 'id']);
    }

    /**
     *   Корзина
     * @return \yii\db\ActiveQuery
     */
    public function getBasket()
    {
        return $this->hasMany(BookingBasket::class, ['sanatorium_booking_id' => 'id']);
    }

    /**
     * Relation comments
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['booking_id' => 'id']);
    }

    /**
     *   Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
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

        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * Получить текст с количеством проживающих
     */

    public static function getViewNumberPeople($adult, $children)
    {

        $text = '';

        if ($adult) {
            $text .= Yii::t('sanatorium', 'Adults') . ': ' . $adult;
        }

        if ($children) {
            $text .= Yii::t('sanatorium',
                '{n, plural, =0{No children} =1{# child} one{# children} few{# children} many{# children} other{# children}}',
                [
                    'n' => $children
                ]);
        }


        return $text;
    }


    /**
     * @param $sanatorium_id
     * @param $sanatoriumRoomTypeId
     * @param $dateFrom
     * @param $dateTo
     * @param null $numberPeople
     * @return int
     */
    //TODO  Получение количества доступных номеров Комнаты
    public static function getNumberBookedRooms($sanatorium_id, $sanatoriumRoomTypeId, $dateFrom, $dateTo, $numberPeople = null)
    {

        $roomParams = Selection::getNumberBookedRoomsBySanatorium($sanatorium_id, $dateFrom, $dateTo);
        return (isset($roomParams[$sanatoriumRoomTypeId]['freeRooms'])) ? $roomParams[$sanatoriumRoomTypeId]['freeRooms'] : 0;
    }


    /**
     *
     * Штраф
     */

    public function getPenalty($date, $price)
    {
        return (isset($this->sanatorium->penalties)) ? $this->sanatorium->penalties->getPenalty($date, $price) : 0;
    }


    /**
     * Статусы бронирования
     */

    public static function dropDownListStatusBooking()
    {
        return [
            self::STATUS_ADD_MANAGER_ONE_ROOM => Yii::t('app', 'Booking one room'),
            self::STATUS_ADD_MANAGER_ALL_ROOMS => Yii::t('app', 'Booking all rooms')
        ];
    }

    /**
     * Удаление бронирования
     */

    public function deleteBooking()
    {
        $this->setScenario('cancel');
        $this->status = Booking::STATUS_CANCELLED;
        $this->cancellation_date = time();

        return $this->save();
    }

    /**
     * @return int|mixed
     */
    public function getNumberNights()
    {
        return ($this->number_days > 0) ? $this->number_days - 1 : 0;
    }

}
