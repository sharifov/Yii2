<?php

namespace thread\modules\manual\models;

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
class MedicalbaseLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\manual\Manual::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%manual_medical_base_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Medicalbase::class, 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'safe'],
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
            'title' => Yii::t('app', 'title'),
            'content' => Yii::t('app', 'content'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['title', 'content'],
        ];
    }
}
