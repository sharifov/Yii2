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
class RelRoomTypeFacilitiesRooms extends \thread\models\ActiveRecord
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
        return '{{%sanatorium_roomtype_rel_facilitiesservices}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'facilities_rooms_id', 'room_type_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'room_type_id' => Yii::t('app', 'room_type_id'),
            'facilities_rooms_id' => Yii::t('app', 'facilities_rooms_id'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['room_type_id', 'facilities_rooms_id'],
        ];
    }

}
