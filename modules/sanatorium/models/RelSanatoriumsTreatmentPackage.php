<?php

namespace thread\modules\sanatorium\models;

use thread\modules\manual\models\Medicalbase;
use thread\modules\manual\models\TreatmentPackage;
use vova07\fileapi\behaviors\UploadBehavior;
use frontend\modules\sanatorium\models\RelSanatoriumsTreatmentPackageFrontend;
use Yii;

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
class RelSanatoriumsTreatmentPackage extends \thread\models\ActiveRecord
{
    private $published;
//    const type = [0, 1, 3, 7, 10];
    const type = ['0' => '0', '1' => '1', '3' => '3', '7' => '7', '10' => '10'];

    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\sanatorium\Sanatorium::getDb();
    }

    public function behaviors()
    {
        return [];
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%sanatorium_rel_treatment_package}}';
    }


    public function rules()
    {
        return [
            [['sanatorium_id', 'treatment_package_id', 'whole_stay'], 'integer'],
            [['type', 'whole_stay'], 'in', 'range' => array_keys(self::type)],
            [['value'],  'double'],
            [['value'],  'default', 'value' => 0],
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
            'treatment_package_id' => Yii::t('app', 'treatment_package_id'),
            'value' => Yii::t('app', 'value'),
            'type' => Yii::t('app', 'tr_type'),
            'whole_stay' => Yii::t('app', 'Whole stay'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['sanatorium_id', 'treatment_package_id', 'value', 'type', 'whole_stay'],
        ];
    }


    /**
     * Санаторий
     * @return \yii\db\ActiveQuery || null
     */

    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    /**
     * Санаторий
     * @return \yii\db\ActiveQuery || null
     */

    public function getTreatmentPackage()
    {
        return $this->hasOne(TreatmentPackage::class, ['id' => 'treatment_package_id']);
    }

    /**
     * Импровизация проверки модели
     * @return \yii\db\ActiveQuery || null
     */

    public  function getPublished() {
        return $this->published = ($this->isNewRecord) ? 0 : 1;
    }

    public  function setPublished($value) {
        return $this->published = $value;
    }

}
