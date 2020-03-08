<?php

namespace thread\modules\widgetsetting\models;

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
class ChoiceResortWidgetLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\widgetsetting\Widgetsetting::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%widget_choice_resort_lang}}';
    }

    public function behaviors() {
        return [];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['rid', 'exist', 'targetClass' => ChoiceResortWidget::class, 'targetAttribute' => 'id'],
            [['content'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => Yii::t('app', 'content'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'meta_desc' => Yii::t('app', 'meta_desc'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_h1' => Yii::t('app', 'meta_h1'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => [
                'content',                
                'meta_title',
                'meta_desc',
                'meta_keywords',
                'meta_h1',
            ],

        ];
    }

}
