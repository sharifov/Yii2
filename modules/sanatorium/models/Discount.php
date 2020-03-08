<?php

namespace thread\modules\sanatorium\models;
use Yii;

class Discount extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_discount}}';
    }

    public function rules()
    {
        return [
            [['begin_discount', 'end_discount'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'sanatorium_room_type', 'sanatorium_id', 'prior_to', 'update_time'], 'integer'],
            [['discount'], 'double'],
            [['discount', 'prior_to'], 'default', 'value' => 0],
            [['begin_discount', 'end_discount'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'update_time' => Yii::t('app', 'update_time'),
            'begin_discount' => Yii::t('app', 'begin_discount'),
            'end_discount' => Yii::t('app', 'end_discount'),
            'prior_to' => Yii::t('app', 'prior_to'),
            'discount' => Yii::t('app', 'discount'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'sanatorium_room_type' => Yii::t('app', 'Roomtype'),
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
            'date' => ['begin_discount', 'end_discount', 'published', 'sanatorium_id'],
            'backend' => [
                'begin_discount',
                'end_discount',
                'prior_to',
                'discount',
                'sanatorium_id',
                'sanatorium_room_type',
                'published'
            ],
        ];
    }

//    /**
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getLang()
//    {
//        return $this->hasOne(DiscountLang::class, ['rid' => 'id']);
//    }

    /**
     *  Вид номерова санатория
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(Roomtype::class, ['id' => 'sanatorium_room_type']);
    }

    /**
     * @return mixed
     */
    public static function find_base()
    {
        return parent::find_base()->enabled();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByRoomType($id)
    {
        return self::find_base()->andWhere(['sanatorium_room_type' => $id])->all();
    }

}
