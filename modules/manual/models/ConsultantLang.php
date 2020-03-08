<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;


class ConsultantLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\manual\Manual::getDb();
    }

    public function behaviors() {
       return [];
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%manual_consultants_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['rid', 'exist', 'targetClass' => Consultant::class, 'targetAttribute' => 'id'],
            [[ 'specialization', 'fio', 'info'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'specialization' => Yii::t('manual', 'specialization'),
            'fio' => Yii::t('manual', 'fio'),
            'info' => Yii::t('app', 'info'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['desc_short', 'specialization', 'fio', 'info'],
        ];
    }
}
