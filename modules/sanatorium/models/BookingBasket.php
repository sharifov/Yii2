<?php

namespace thread\modules\sanatorium\models;

use Yii;

class BookingBasket extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_booking_basket}}';
    }

    public function rules()
    {
        return [
            [['sanatorium_booking_id', 'sanatorium_room_type_id', 'price_basic', 'price_user'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['sanatorium_booking_id', 'sanatorium_room_type_id'], 'integer'],
            [
                ['price_basic', 'price_user', 'price_user_discount', 'price_basic_discount', 'price_sanatorium', 'price_sanatorium_discount'],
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
            'sanatorium_room_type_id' => Yii::t('app', 'sanatorium_room_type_id'),
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
                'sanatorium_room_type_id',
                'price_basic',
                'price_user',
                'published',
                'price_basic_discount',
                'price_user_discount',
                'price_sanatorium',
                'price_sanatorium_discount',
            ],
        ];
    }

    /**
     *   Пользователи которые забронировали номера
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(BookingUser::class, ['booking_basket_id' => 'id'])->orderBy('age ASC, extra_bed ASC');
    }


    /**
     *   Бронирование
     * @return \yii\db\ActiveQuery
     */
    public function getBooking()
    {
        return $this->hasOne(Booking::class, ['id' => 'sanatorium_booking_id']);
    }


    /**
     *   Тип номера
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(Roomtype::class, ['id' => 'sanatorium_room_type_id']);
    }

    /**
     * Получаем куррс
     */
    public function getCourseAttr($attribute = null)
    {
        if ($attribute) {
            return (isset($this->booking->currency->$attribute)) ? $this->booking->currency->$attribute : null;
        }

        return (isset($this->booking->currency)) ? $this->booking->currency : null;
    }


//    /**
//     * @param type $insert
//     * @param type $changedAttributes
//     */
//    public function afterSave($insert, $changedAttributes) {
//
//        $this->booking->number_guests = self::find()->andWhere(['sanatorium_booking_id' => $this->sanatorium_booking_id])->count();
//        $this->booking->save();
//
//        parent::afterSave($insert, $changedAttributes);
//    }
//
//    // НАДО ПРОВЕРИТЬ!!!!!!
//    public function afterDelete()
//    {
//        parent::afterDelete();
//        $this->booking->number_guests = self::find()->andWhere(['sanatorium_booking_id' => $this->sanatorium_booking_id])->count();
//        $this->booking->save();
//    }

        public function deleteBooking($sanatorium_booking_id)
    {

        $model = BookingBasket::findOne($sanatorium_booking_id);
        $model->delete();
    }


}
