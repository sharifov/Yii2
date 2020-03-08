<?php

namespace thread\modules\sanatorium\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

/**
 * This is the model class for table "fv_sanatorium_rooms_lang".
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $desc_short
 *
 * @property string anatoriumRooms
 */
class RoomtypeLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\sanatorium\Sanatorium::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%sanatorium_room_type_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
//            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Roomtype::class, 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 255],
            [['room_features', 'additional_room_features','room_smoking'], 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('sanatorium', 'title'),
            'room_features' => Yii::t('sanatorium', 'Room features'),
            'additional_room_features' => Yii::t('sanatorium', 'Additional room features'),
            'room_smoking' => Yii::t('sanatorium', 'Room Smoking'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => [
                'title',
                'room_features',
                'additional_room_features',
                'room_smoking',
            ],
        ];
    }

}
