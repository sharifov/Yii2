<?php

namespace thread\modules\location\models;

use thread\behaviors\TransliterateBehavior;
use thread\modules\sanatorium\models\Sanatoriums;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Class Country
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Country extends \thread\models\ActiveRecord
{

    const PATH_TO_FLAG_IMAGES = 'images/flags';

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\location\Location::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_country}}';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     *
     * All country
     * @return Array
     */
    public static function dropDownList()
    {
        return ArrayHelper::merge(['0' => 'Choose...'],
            ArrayHelper::map(self::find_base()->orderBy('title')->all(), 'id', 'lang.title'));

//        $models = self::find_base()->orderBy('title')->all();
//        $items = [];
//        $options = [];
//        foreach($models as $model){
//            //Формируем массив option'ов для нашего select'а
//            $items[$model->id] = $model->lang->title;
//            //Формируем массив атрибутов для каждого option'а
//            //Эти атрибуты(data-imagesrc, data-description) нужны для плагина
//            $options[$model->id] = [
//                'data-country-code' => $model->alpha2
//            ];
//        }
//        return Html::dropDownList('Booking[country_id]', 'id', $items, [
//            'options' => $options,
//            'class'=>'form-control border-colors oiwjoidjw',
//            'id'=>'booking-country_id',
//        ]);
    }

    /**
     * ДЛЯ IS ARRAY
     *
     * @param $id
     * @return string
     */

    public static function getStaticUrl($alias)
    {
        return Url::toRoute(['/sanatorium/filter/view', 'country_alias' => $alias]);
//        return Url::toRoute(['/sanatorium/country/view', 'alias' => $alias,"couList"=>$id]);
    }

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'transliterate' => [
                'class' => TransliterateBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['alias' => 'alias'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['alias' => 'alias']
                ]
            ],
        ]);
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [
                [
                    'create_time',
                    'on_main',
                    'view_for_sanatorium',
                    'position',
                    'update_time',
                    'iso',
                    'visa',
                    'visa_supply'
                ],
                'integer'
            ],
            [['published', 'deleted', 'visa', 'visa_supply'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['position'], 'default', 'value' => 0],
            [['alias'], 'string', 'max' => 128],
            [['search_title'], 'string', 'max' => 255],
            [['alpha2'], 'string', 'min' => 2, 'max' => 2],
            [['alpha3'], 'string', 'min' => 3, 'max' => 3],
            [['alias'], 'unique'],
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
                'alpha2',
                'alpha3',
                'iso',
                'published',
                'deleted',
                'search_title',
                'visa',
                'view_for_sanatorium',
                'visa_supply',
                'position',
                'country_code',
            ],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'alpha2' => Yii::t('app', 'alpha2'),
            'alpha3' => Yii::t('app', 'alpha3'),
            'iso' => Yii::t('app', 'iso'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'search_title' => Yii::t('app', 'search_title'),
            'visa' => Yii::t('app', 'Need visa'),
            'visa_supply' => Yii::t('app', 'Visa supply'),
            'view_for_sanatorium' => Yii::t('app', 'view_for_sanatorium'),
            'position' => Yii::t('app', 'position'),
            'country_code' => Yii::t('app', 'country_code'),
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CountryLang::class, ['rid' => 'id']);
    }

    public function getNumberCities($number = 0)
    {
        return $this->getCities()->limit($number)->all();
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::class, ['location_country_id' => 'id']);
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getSanatoriums()
    {
        return $this->hasMany(Sanatoriums::class, ['location_country_id' => 'id'])->enabled();
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getCurrencies()
    {
        return $this->hasMany(Currency::class, ['id' => 'currency_id'])
            ->viaTable('fv_location_rel_country_currency', ['country_id' => 'id']);
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::class, ['id' => 'language_id'])
            ->viaTable('fv_location_rel_country_language', ['country_id' => 'id']);
    }

    public function getUrl()
    {
//        return Url::toRoute(['/sanatorium/filter/view', SearchParams::nameCountryList => $this->id]);
        return Url::toRoute(['/sanatorium/country/view', 'alias' => $this->alias, 'couList' => $this->id]);
    }

    public function getBreadcrumbUrl ($scheme = false)
    {
        return Url::toRoute(['/sanatorium/filter/view', 'country_alias' => $this->alias], $scheme);
    }

    /**
     *
     * All country
     * @return Array
     */


    // Дописать проверку на наличие файла

    /**
     * @param string $size
     *
     * @return string
     */
    public function getImageFlagLink($size = '64')
    {

        if (file_exists($this->getBasePathFlagImage($size) . '/' . $this->getFileName())) {
            return $this->getGalleryBaseUrl($size) . '/' . $this->getFileName();
        }
    }

    /**
     *
     * //
     * @return string
     */
    public function getBasePathFlagImage($size)
    {
        return Yii::getAlias('@root') . '/frontend/' . self::PATH_TO_FLAG_IMAGES . '/' . $size;
    }

    public function getFileName()
    {
        return ($this->alias) ? $fileName = ucfirst($this->alias) . '.png' : '';
    }

    /**
     *
     * @return string
     */
    public function getGalleryBaseUrl($size)
    {
        return Yii::$app->request->hostInfo . '/' . self::PATH_TO_FLAG_IMAGES . '/' . $size;
    }

}
