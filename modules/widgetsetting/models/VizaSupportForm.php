<?php

namespace thread\modules\widgetsetting\models;
use thread\modules\location\models\City;
use thread\modules\location\models\Country;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class VizaSupportForm extends \thread\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_viza_support_form}}';
    }

    public static function getDb()
    {
        return \thread\modules\company\CompanyModule::getDb();
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'your_country',
                    'country_viza',
                    'create_time',
                    'update_time',
                ],
                'integer'
            ],
            [['first_name', 'phone', 'email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'firstname' => Yii::t('front', 'First name'),
            'phone' => Yii::t('front', 'Phone'),
            'email' => Yii::t('front', 'Email'),
            'your_country' => Yii::t('front', 'Country visa'),
            'country_viza' => Yii::t('front', 'The country in which you are planning to go'),
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
                'your_country',
                'country_viza',
                'create_time',
                'update_time',
                'first_name',
                'phone',
                'email',
                'deleted',
                'published'
            ],
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getYourCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'your_country'])->enabled();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVizaCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_viza'])->enabled();
    }
}
