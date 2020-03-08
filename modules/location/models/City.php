<?php

namespace thread\modules\location\models;

use frontend\components\SearchParams;
use thread\modules\sanatorium\models\Sanatoriums;
use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;
use yii\helpers\Url;


class City extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */

    public static function getDb()
    {
        return \thread\modules\location\Location::getDb();
    }


    /**
     * @return string
     */

    public static function tableName()
    {
        return '{{%location_city}}';
    }


    /**
     * @return array
     */

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'transliterate' => [
                'class' => TransliterateBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['alias' => 'alias'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['alias' => 'alias']
                ]
            ],
        ]);
    }


    /**
     * @return array
     */

    public function rules()
    {
        return [
//            [['alias'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['location_country_id', 'create_time', 'update_time'], 'integer'],
            [['alias', 'search_title'], 'string', 'max' => 255],
            [['alias'], 'unique'],
        ];
    }


    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'location_country_id' => Yii::t('location', 'location_country_id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'search_title' => Yii::t('app', 'search_title'),
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
                'alias',
                'location_country_id',
                'create_time',
                'update_time',
                'published',
                'deleted',
                'search_title'
            ],
        ];
    }


    /**
     * @return mixed
     */

    public static function find_base()
    {
        return parent::find_base()->innerJoinWith(['lang']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */

    public function getLang()
    {
        return $this->hasOne(CityLang::class, ['rid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'location_country_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */

    public function getSanatoriums()
    {
        return $this->hasMany(Sanatoriums::class, ['location_city_id' => 'id']);

    }


    /**
     *
     * @return array [id=>title]
     */

    public static function dropDownList($country_id = false)
    {

        if ($country_id) {
            $items = self::find_base()->andWhere(['IN', 'location_country_id', $country_id])->all();
        } else {
            $items = self::find_base()->all();
        }

        return ArrayHelper::merge(['0' => 'Choose...'], ArrayHelper::map($items, 'id', 'lang.title'));
    }


    /**
     * @param bool $insert
     * @return bool
     */

    public function beforeSave($insert)
    {
        $title = (isset(Yii::$app->request->post('CityLang')['title'])) ? Yii::$app->request->post('CityLang')['title'] : null;

        if ((empty($this->alias)) && $title) {
            $this->alias = $title;
        }

        if (parent::beforeSave($insert)) {

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */

    public function getUrl()
    {
        return self::getStaticUrl($this->id, $this->location_country_id);
    }

    /**
     *  Специально!! для IS ARRAY)))
     *
     * @param $id
     * @param $scheme
     * @return string
     */

    public static function getStaticUrl($city_alias, $country_alias, $country_id, $city_id, $scheme = false)
    {
//        return Url::toRoute(['/sanatorium/city/view', 'country_alias' => $country_alias, 'alias' => $city_alias, 'couList'=>$country_id, 'cty_slct[]'=>$city_id ], $scheme);
        return Url::toRoute(['/sanatorium/filter/view', 'country_alias' => $country_alias, 'city_alias' => $city_alias], $scheme);
    }

    /**
     * @return string
     */
    public function getViewUrl($country_alias=null,$city_alias=null,$country_id=null,$city_id=null)
    {
//        return self::getStaticUrl($this->id, $this->location_country_id);
        return Url::toRoute(['/sanatorium/city/view', 'country_alias' => $country_alias, 'alias' => $city_alias, 'couList'=>$country_id, 'cty_slct[] '=>$city_id]);
    }

    public function getViewBreadcrumbUrl($country_alias=null,$city_alias=null)
    {
//        return self::getStaticUrl($this->id, $this->location_country_id);
        return Url::toRoute(['/sanatorium/filter/view', 'country_alias' => $country_alias, 'city_alias' => $city_alias]);
    }

}
