<?php

namespace thread\modules\sanatorium\models;
use Yii;

/**
 * Возраст  детей для формирования цен ( Возраст считаеться Не включительно (0 - 4) от 0 ДО 4-х  !)
 * Class ChildrenAge
 * @package thread\modules\sanatorium\models
 */
class ChildrenAge extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_children_age}}';
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['age_begin', 'age_end'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time',  'age_begin', 'age_end', 'sanatorium_id', 'position', 'update_time'], 'integer'],
            [['position'], 'default', 'value' => 0]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'age_begin' => Yii::t('app', 'Age begin'),
            'age_end' => Yii::t('app', 'Age end'),
            'position' => Yii::t('app', 'position'),

            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }


    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'sanatorium_id',
                'age_begin',
                'age_end',
                'position',
                'published'
            ],
        ];
    }

    /**
     *  Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    /**
     * @return mixed
     */
    public static function find_base()
    {
        return parent::find_base()->enabled()->orderBy('position DESC');
    }

    /**
     * @param $sanatoriumId
     * @return mixed
     */
    public static function getChildrenBySanatoriumId($sanatoriumId)
    {
        return self::find_base()->andWhere(['sanatorium_id' => $sanatoriumId])->all();
    }


}
