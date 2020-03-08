<?php

namespace thread\modules\company\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class TransferpointsLang
 *
 * @package thread\modules\company\models
 */
class TransferpointsLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\company\CompanyModule::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%company_transfer_points_lang}}';
    }


    /**
     *
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Transferpoints::class, 'targetAttribute' => 'id'],
            [['title'], 'string', 'max' => 255],
        ]);
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title'],
        ];
    }

}
