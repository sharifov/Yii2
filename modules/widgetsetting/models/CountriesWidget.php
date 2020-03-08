<?php

namespace thread\modules\widgetsetting\models;

use thread\modules\location\models\City;
use thread\modules\location\models\Country;
use Yii;

class CountriesWidget extends \thread\models\ActiveRecord {

    /**
     * Массив для связи Active record Городов
     */
    private $cityes_array;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%widget_countries}}';
    }

    /**
     * 
     * @return stirng
     */
    public static function getDb() {
        return \thread\modules\company\CompanyModule::getDb();
    }

    /**
     * 
     * @return type
     */
    public function rules() {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['columns'], 'in', 'range' => array_keys(static::numberColumnsRange())],
            [
                [
                    'country_id',
                    'main_city_id',
                    'create_time',
                    'update_time',
                    'position',
                ],
                'integer'
            ],
            [['image_link'], 'string', 'max' => 255],
            ['cities_id', 'safe'],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'country_id' => Yii::t('app', 'country_id'),
            'main_city_id' => Yii::t('app', 'city_id'),
            'cities_id' => Yii::t('widgetsetting', 'cities_id'),
            'image_link' => Yii::t('app', 'image_link'),
            'position' => Yii::t('app', 'position'),
            'columns' => Yii::t('widgetsetting', 'Number of columns'),
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => [
                'country_id',
                'main_city_id',
                'cities_id',
                'image_link',
                'position',
                'columns',
            ],
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getCountry() {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->enabled();
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getMainCity() {
        return $this->hasOne(City::class, ['id' => 'main_city_id'])->enabled();
    }

    /**
     *
     * Return unserialize cities_id
     * @return Array
     */
    public function getUnserializeCities() {
        return (!empty($this->cities_id)) ? unserialize($this->cities_id) : '';
    }

    /**
     *
     * Get image link
     * @return string
     */
    public function getImageLinkUrl() {
//        Заменить на Yii::$app->getModule('news')->getImageBaseUrl()

        return ($this->image_link) ? 'frontend/upload/widgetsetting/countrieswidget' . '/' . $this->image_link : '';
    }

    /**
     *
     * All country
     * @return Array
     */
    public function getCitiesModels($limit = null) {

        $arrayCities = $this->getUnserializeCities();
        $modelCities = false;

        if (!empty($arrayCities) && is_array($arrayCities)) {
            $modelCities = City::find_base()->andWhere(['id' => $arrayCities]);

            if ($limit) {
                $modelCities = $modelCities->limit($limit);
            }
            $modelCities = $modelCities->all();
        }

        return $modelCities;
    }

    /**
     * @return array
     */
    public static function numberColumnsRange() {
        return [
            '1 column' => Yii::t('widgetsetting', '1 column'),
            '2 column' => Yii::t('widgetsetting', '2 column'),
            '3 column' => Yii::t('widgetsetting', '3 column'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find_base()
    {
        return self::find()->joinWith(['mainCity', 'country'])->enabled()->orderBy(['position' => SORT_ASC]);
    }

}
