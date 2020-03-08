<?php

namespace thread\modules\sanatorium\models;
use Yii;

class Discountlie extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%discount_lie}}';
    }

    public function rules()
    {
        return [
            [['sanatorium_id'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'sanatorium_id', 'update_time'], 'integer'],
            [['discount'], 'double'],
            [['discount'], 'default', 'value' => 0],
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
            'discount' => Yii::t('app', 'discount'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
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
            'date' => [ 'published', 'sanatorium_id'],
            'backend' => [
                'discount',
                'sanatorium_id',
                'published'
            ],
        ];
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
