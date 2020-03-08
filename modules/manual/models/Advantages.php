<?php

namespace thread\modules\manual\models;

use Yii;

class Advantages extends \thread\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_advantages}}';
    }

    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'position', 'update_time'], 'integer'],
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
        return $this->hasOne(AdvantagesLang::class, ['rid' => 'id']);
    }

}
