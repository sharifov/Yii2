<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;


class Medicaloffice extends \thread\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_medical_office}}';
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'position', 'update_time'], 'integer'],
            [['position'],  'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'position' => Yii::t('app', 'position')
        ];
    }


    /**
     *
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted'   => ['deleted'],
            'backend'   => ['position', 'create_time', 'update_time', 'published', 'deleted'],
        ];
    }

    public function getLang()
    {
        return $this->hasOne(MedicalofficeLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownList()
    {
        return ArrayHelper::map(self::find_base()->enabled()->all(), 'id', 'lang.title');
    }

}
