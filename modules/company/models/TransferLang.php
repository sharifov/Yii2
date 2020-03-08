<?php

namespace thread\modules\company\models;

use Yii;
use yii\helpers\ArrayHelper;


class TransferLang extends \thread\models\ActiveRecordLang
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_transfer_lang}}';
    }
    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\company\CompanyModule::getDb();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Transfer::class, 'targetAttribute' => 'id'],
            [['info', 'title'], 'string', 'max' => 255],
            [['booking_policy'], 'string'],
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
            'info' => Yii::t('app', 'info'),
            'booking_policy' => Yii::t('app', 'Booking policy'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['info', 'title', 'booking_policy'],
        ];
    }
}
