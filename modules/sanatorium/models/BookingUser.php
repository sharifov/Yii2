<?php

namespace thread\modules\sanatorium\models;

use Yii;

class BookingUser extends \thread\models\ActiveRecord
{
//
//    const AGE_ADULT = 'Adult'; // >= 12
//    const AGE_TEEN = 'Teen';   // 11 - 6
//    const AGE_CHILD = 'Child'; // 2 - 5

    /**
     * Типы питания
     */

    const TYPE_FOOD_FBT = 'FBT';
    const TYPE_FOOD_HBT = 'HBT';
    const TYPE_FOOD_HB = 'HB';
    const TYPE_FOOD_FB = 'FB';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_booking_users}}';
    }

    public function rules()
    {
        return [
            [['name', 'surname'], 'required'],
            [['type_food'], 'in', 'range' => array_keys(static::statusTypeFood())],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['sanatorium_booking_id', 'age', 'booking_basket_id', 'sanatorium_room_type_id'], 'integer'],
            [['surname', 'name'], 'string', 'max' => 255],
            [
                ['price_basic', 'price_user', 'price_basic_discount', 'price_user_discount', 'price_sanatorium', 'price_sanatorium_discount'],
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
            'sanatorium_booking_id' => Yii::t('app', 'sanatorium_booking_id'),
            'name' => Yii::t('app', 'name'),
            'surname' => Yii::t('app', 'surname'),
            'published' => Yii::t('app', 'published'),
            'sanatorium_room_type_id' => Yii::t('app', 'sanatorium_room_type_id'),
            'booking_basket_id' => Yii::t('app', 'booking_basket_id'),
            'price_basic' => Yii::t('app', 'price_basic'),
            'price_user' => Yii::t('app', 'price_user'),
            'price_basic_discount' => Yii::t('app', 'price_basic_discount'),
            'price_user_discount' => Yii::t('app', 'price_user_discount'),
            'price_sanatorium' => Yii::t('app', 'price_sanatorium'),
            'price_sanatorium_discount' => Yii::t('app', 'price_sanatorium_discount'),
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
                'sanatorium_booking_id',
                'name',
                'surname',
                'published',
                'sanatorium_room_type_id',
                'booking_basket_id',
                'price_user',
                'price_basic',
                'price_basic_discount',
                'price_user_discount',
                'price_sanatorium',
                'price_sanatorium_discount'
            ],
        ];
    }


    /**
     *   Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(Roomtype::class, ['id' => 'sanatorium_room_type_id']);
    }

    /**
     *   Забронированый номре
     * @return \yii\db\ActiveQuery
     */
    public function getBookingBasket()
    {
        return $this->hasOne(BookingBasket::class, ['id' => 'booking_basket_id']);
    }


    /**
     *   Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(Booking::class, ['id' => 'sanatorium_booking_id']);
    }

    /**
     * Full first and last name
     * @return string
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

    // НАДО ПРОВЕРИТЬ!!!!!!
    public function afterDelete()
    {
        parent::afterDelete();
        $this->booking->number_guests = self::find()->andWhere(['sanatorium_booking_id' => $this->sanatorium_booking_id])->count();
        $this->booking->save();
    }

    /**
     * @return array
     */
    public static function statusTypeFood()
    {
        return [
            self::TYPE_FOOD_FBT,
            self::TYPE_FOOD_HBT,
            self::TYPE_FOOD_HB,
        ];
    }


//    /**
//     * @return array
//     */
//    public static function statusAge()
//    {
//        return [
//            self::AGE_ADULT,
//            self::AGE_TEEN,
//            self::AGE_CHILD,
//        ];
//    }


    /**
     * Получаем возраст в строке
     * @return string
     */
    public function getAgeToString($number = '')
    {

        if ($this->age > 18) {
            return Yii::t('front', 'Adult');
        } else {
            return Yii::t('front', 'Child');
        }
    }


    /**
     * Получаем тип питания
     * @return string
     */
    public function getTypeFoodToString()
    {
        $type_food = '';

        switch ($this->type_food) {
            case(self::TYPE_FOOD_FBT): {
                $type_food = Yii::t('front', '3 meals a day c treatment');
                break;
            }

            case(self::TYPE_FOOD_HBT): {
                $type_food = Yii::t('front', '2 meals a day c treatment');
                break;
            }

            case(self::TYPE_FOOD_FB): {
                $type_food = Yii::t('front', '3 meals a day without treatment');
                break;
            }

            case(self::TYPE_FOOD_HB): {
                $type_food = Yii::t('front', '2 meals a day without treatment');
                break;
            }

        }

        return $type_food;
    }

}
