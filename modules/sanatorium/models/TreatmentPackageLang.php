<?php

namespace thread\modules\sanatorium\models;

use Yii;
use yii\helpers\ArrayHelper;

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
class TreatmentPackageLang extends \thread\models\ActiveRecordLang
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
        return '{{%sanatorium_treatment_package_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => TreatmentPackage::class, 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 255],
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
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['title'],
        ];
    }

}
