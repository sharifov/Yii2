<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;


class Rooms extends \thread\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_rooms}}';
    }

    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\manual\Manual::getDb();
    }


    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'position', 'update_time'], 'integer'],
            [['position'], 'default', 'value' => 0],
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
            'position' => Yii::t('app', 'position'),
        ];
    }

    /**
     *
     * @return array
     */
    public static function dropDownList() {
        return  ArrayHelper::merge(['0' => Yii::t('app', 'Not selected')], ArrayHelper::map(self::find_base()->undeleted()->all(), 'id', 'lang.title'));
    }

    /**
     *
     * @return array
     */
    public static function dropDownListModel() {
        return self::find_base()->undeleted()->all();
    }

    /**
     *
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted'   => ['deleted'],
            'backend'   => ['create_time', 'position', 'update_time', 'published', 'deleted'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(RoomsLang::class, ['rid' => 'id']);
    }

}
