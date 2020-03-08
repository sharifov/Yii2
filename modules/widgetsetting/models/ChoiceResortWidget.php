<?php

namespace thread\modules\widgetsetting\models;

use thread\modules\location\models\City;
use thread\modules\location\models\Country;
use thread\modules\page\models\Page;
use Yii;
use yii\helpers\Url;

class ChoiceResortWidget extends \thread\models\ActiveRecord
{

    public $currentPage = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_choice_resort}}';
    }

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\widgetsetting\Widgetsetting::getDb();
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['city_id', 'country_id'], 'integer'],
            [['alias'], 'string', 'max' => 255],
            [['alias', 'city_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => Yii::t('app', 'city_id'),
            'country_id' => Yii::t('app', 'country_id'),
            'alias' => Yii::t('app', 'alias'),
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
                'city_id',
                'country_id',
                'alias'
            ],
        ];
    }

    public function getLang()
    {
        return $this->hasOne(ChoiceResortWidgetLang::class, ['rid' => 'id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }


    /**
     * Получить выборку стран
     */

    public static function getNavigationCountry()
    {
        return self::find_base()->innerJoinWith('country')->orderBy(Country::tableName() . '.position DESC,'.Country::tableName() . '.id DESC')->groupBy(self::tableName() . '.country_id')->all();
    }

    /**
     ** Получить модели с страной модели
     */
    public function getSelfCityModel()
    {
        return $this->hasMany(self::class, ['country_id' => 'country_id'])->enabled();
    }


    public function getUrl($scheme = true)
    {
        if ($this->getCurrentPage()) {
            return Url::to(['/vibor-kurorta/'. $this->alias], $scheme);
        }
    }

    /**
     * Модель страницы
     * @param null $attribute
     * @return null|\thread\modules\page\models\ActiveRecord
     */
    public function getCurrentPage($attribute = null) {

        if ($this->currentPage === null) {
            $this->currentPage = Page::findWithWidget(Page::PAGE_RESORT);
        }

        return ($attribute && isset($this->currentPage[$attribute])) ? $this->currentPage[$attribute] : $this->currentPage;
    }


    public function getLink()
    {
        return Url::current(['resort' => $this->alias]);
    }

    public function beforeSave($insert)
    {

        if (isset($this->city)) {
            $this->alias = $this->city->alias;
        }

        return parent::beforeSave($insert);
    }

}
