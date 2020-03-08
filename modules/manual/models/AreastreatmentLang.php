<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class AreastreatmentLang
 *
 * @package thread\modules\manual\models
 */
class AreastreatmentLang extends \thread\models\ActiveRecordLang
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
        return '{{%manual_areas_treatment_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Areastreatment::class, 'targetAttribute' => 'id'],
            [['info'], 'string', 'max' => 255],
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
            'title' => Yii::t('app', 'title'),
            'info' => Yii::t('app', 'info'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'meta_desc' => Yii::t('app', 'meta_desc'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_h1' => Yii::t('app', 'meta_h1'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['title', 'info','meta_title','meta_desc','meta_keywords','meta_h1'],
        ];
    }

}
