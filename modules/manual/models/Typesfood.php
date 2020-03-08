<?php

namespace thread\modules\manual\models;

use frontend\modules\sanatorium\models\Price;
use Yii;
use yii\helpers\ArrayHelper;


class Typesfood extends \thread\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_types_food}}';
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
        return ArrayHelper::map(self::find_base()->all(), 'id', 'lang.title');
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

    public function getLang()
    {
        return $this->hasOne(TypesfoodLang::class, ['rid' => 'id']);
    }

    /**
     * Вынести в модель FRONTEND
     *
     * @return array
     */
    public static function dropDownListFrontend() {
        return [
            Price::TYPE_FOOD_FBT => '3-разовое питание с лечением',
            Price::TYPE_FOOD_HBT => '2-разовое питание с лечением',
        ];
    }

}
