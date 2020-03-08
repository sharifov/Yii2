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
class HowToHelpWidgetLang extends \thread\models\ActiveRecordLang
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
        return '{{%widget_how_to_help_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => HowToHelpWidget::class, 'targetAttribute' => 'id'],
            [['title', 'info', 'btn_name'], 'string', 'max' => 255],
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
            'btn_name' => Yii::t('app', 'btn_name'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['title', 'info', 'btn_name'],
        ];
    }

}
