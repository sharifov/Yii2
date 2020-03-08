<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class HoteloptionsLang
 *
 * @package thread\modules\manual\models
 */
class HoteloptionsLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\manual\Manual::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%manual_hotel_options_lang}}';
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Hoteloptions::class, 'targetAttribute' => 'id'],
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
            'title' => Yii::t('app', 'title')
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
