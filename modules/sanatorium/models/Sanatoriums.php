<?php

namespace thread\modules\sanatorium\models;

use thread\modules\company\models\Company;
use thread\modules\location\models\City;
use thread\modules\location\models\Country;
use thread\modules\location\models\Currency;
use thread\modules\manual\models\Areastreatment;
use thread\modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;
use thread\modules\manual\models\Medicalbase;
use thread\modules\manual\models\Medicaloffice;
use thread\modules\manual\models\Hoteloptions;
use yii\helpers\Url;

/**
 * Class Sanatoriums
 *
 * @package thread\modules\sanatorium\models
 */
class Sanatoriums extends \thread\models\ActiveRecord
{
    const fileUploadFolder = 'upload/sanatorium/item';
    const THUMB = 'thumb_';

    /**
     * ТИпи дисконтов
     */
    const TYPE_DISCOUNT_FOR_DAYS = 'for days';
    const TYPE_DISCOUNT_BEFORE_ARRIVAL = 'before arrival';
    const TYPE_DISCOUNT_DAYS_ARRIVAL = 'days-arrival';

    /**
     * Размеры изображений
     */
    const IMG_SIZE_SANATORIUM_LIST_X = '360';
    const IMG_SIZE_SANATORIUM_LIST_Y = '260';
    const IMG_SIZE_SANATORIUM_LIST = self::IMG_SIZE_SANATORIUM_LIST_X . 'x' . self::IMG_SIZE_SANATORIUM_LIST_Y;


    const ARRAY_TYPE_DISCOUNT = [
        self::TYPE_DISCOUNT_FOR_DAYS,
        self::TYPE_DISCOUNT_BEFORE_ARRIVAL,
        self::TYPE_DISCOUNT_DAYS_ARRIVAL
    ];

    const COUNT_RATING_STARS = [0, 1, 2, 3, 4, 5];

    public $selectedAcceptBankCards = [];

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\sanatorium\Sanatorium::getDb();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_sanatoriums}}';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'transliterate' => [
                'class' => TransliterateBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['alias' => 'alias'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['alias' => 'alias']
                ]
            ]
        ]);
    }

    public function rules()
    {
        return [
            [['alias', 'company_id'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['rating'], 'in', 'range' => self::COUNT_RATING_STARS],

            [['type_discount'],'in', 'range' => self::ARRAY_TYPE_DISCOUNT ],

            [['rating', 'show_personal_count'], 'default', 'value' => 0],
            [['currency_id'], 'default', 'value' => Currency::DEFAULT_CURRENCY_ID],
            [
                [
                    'create_time',
                    'update_time',
                    'company_id',
                    'location_country_id',
                    'location_city_id',
                    'non_card_booking',
                    'cvc_card_booking',
                    'transfer_status',
                    'show_personal_count',
                    'include_resort_rate',
                    'currency_id',
                    'page_index'
                ],
                'integer'],
            [
                [
                    'alias',
                    'adress',
                    'adress_www',
                    'image_main',
                    'gallery_first_image',
                    'adress_www_booking',
                    'adress_map',
                    'youtube_link',
                    'search_title',
                    'transfer_link',
                    'youtube_image'
                ],
                'string',
                'max' => 255
            ],
            [['phone', 'fax', 'postcode', 'latitude_map', 'longitude_map'], 'string', 'max' => 128],
            [
                ['sanatorium_ids', 'hoteloptions_ids', 'medical_office_ids', 'areas_treatment_ids', 'selectedAcceptBankCards'],
                'safe'
            ],
            [['alias'], 'unique'],
//            [['address_www', 'address_www_booking'], 'email'], НЕ ВКЛЮЧАТЬ !!!!!
            [['treatment_rating'], 'double'],
            [['treatment_rating'], 'default', 'value' => 0],
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
            'address' => Yii::t('sanatorium', 'address'),
            'address_www' => Yii::t('sanatorium', 'address_www'),
            'address_www_booking' => Yii::t('sanatorium', 'address_www_booking'),
            'location_country_id' => Yii::t('sanatorium', 'location_country_id'),
            'location_city_id' => Yii::t('sanatorium', 'location_city_id'),
            'phone' => Yii::t('sanatorium', 'phone'),
            'fax' => Yii::t('sanatorium', 'fax'),
            'postcode' => Yii::t('sanatorium', 'postcode'),
            'latitude_map' => Yii::t('sanatorium', 'latitude_map'),
            'longitude_map' => Yii::t('sanatorium', 'longitude_map'),
            'address_map' => Yii::t('sanatorium', 'address_map'),
            'address_panarama' => Yii::t('sanatorium', 'address_panarama'),
            'gallery_link' => Yii::t('app', 'gallery_link'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'company_id' => Yii::t('app', 'company_id'),
            'rating' => Yii::t('sanatorium', 'rating'),
            'hoteloptions' => Yii::t('app', 'Hotel options'),
            'youtube_link' => Yii::t('sanatorium', 'youtube_link'),
            'treatment_rating' => Yii::t('sanatorium', 'treatment_rating'),
            'image_main' => Yii::t('app', 'image_main'),
            'gallery_first_image' => Yii::t('app', 'gallery_first_image'),
            'title' => Yii::t('app', 'title'),
            'non_card_booking' => Yii::t('sanatorium', 'Non card booking'),
            'cvc_card_booking' => Yii::t('sanatorium', 'Cvc card booking'),
            'show_personal_count' => Yii::t('sanatorium', 'Show staff count'),
            'search_title' => Yii::t('app', 'search_title'),
            'accept_bank_cards' => Yii::t('app', 'accept_bank_cards'),
            'include_resort_rate' => Yii::t('app', 'Include resort rate'),
            'transfer_link' => Yii::t('app', 'Transfer link'),
            'transfer_status' => Yii::t('app', 'Transfer status'),
            'type_discount' => Yii::t('app', 'type_discount'),
            'currency_id' => Yii::t('app', 'Currency sanatorium'),
            'youtube_image' => Yii::t('app', 'youtube_image'),
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
                'address',
                'address_www',
                'address_www_booking',
                'location_country_id',
                'location_city_id',
                'phone',
                'fax',
                'postcode',
                'latitude_map',
                'longitude_map',
                'address_map',
                'address_panarama',
                'gallery_link',
                'create_time',
                'update_time',
                'deleted',
                'company_id',
                'published',
                'rating',
                'sanatorium_ids',
                'hoteloptions_ids',
                'medical_office_ids',
                'areas_treatment_ids',
                'youtube_link',
                'treatment_rating',
                'transfer_status',
                'image_main',
                'gallery_first_image',
                'show_personal_count',
                'non_card_booking',
                'cvc_card_booking',
                'search_title',
                'accept_bank_cards',
                'include_resort_rate',
                'transfer_link',
                'type_discount',
                'currency_id',
                'youtube_image',
                'page_index'
            ],
        ];
    }

    /**
     *   Возрасты детей
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenAges()
    {
        return $this->hasMany(ChildrenAge::class, ['sanatorium_id' => 'id']);
    }



    public function getLang()
    {
        return $this->hasOne(SanatoriumsLang::class, ['rid' => 'id']);
    }
    
    public function getPenalties()
    {
        return $this->hasOne(Penalties::class, ['sanatorium_id' => 'id']);
    }

    /**
     * Курс валюты санатория
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    /**
     * Лечебные база
     * @return \yii\db\ActiveQuery
     */
    public function getRelSanMedBase()
    {
        return $this->hasMany(Medicalbase::class, ['id' => 'medical_base_id'])
            ->viaTable('{{%sanatoriums_rel_manual_medical_base}}', ['sanatorium_id' => 'id']);
    }

    /**
     * Направление лечения
     * @return \yii\db\ActiveQuery
     */
    public function getRelSanAreasTreatment()
    {
        return $this->hasMany(Areastreatment::class, ['id' => 'areas_treatment_id'])
            ->viaTable('{{%sanatorium_rel_manual_areas_treatment}}', ['sanatorium_id' => 'id']);
    }

    /**
     *  Промежуточная таблица  Направление лечения
     * @return \yii\db\ActiveQuery
     */
    public function getRelTableSanAreasTreatment($areas_treatment_id = null)
    {
        return $this->hasMany(RelSanatoriumAreasTreatment::class,
            ['sanatorium_id' => 'id'])->andWhere(['areas_treatment_id' => $areas_treatment_id])->all();
    }

    /**
     *    Лечебные отделение
     * @return \yii\db\ActiveQuery
     */
    public function getRelSanMedOffice()
    {
        return $this->hasMany(Medicaloffice::class, ['id' => 'medical_office_id'])
            ->viaTable('{{%sanatorium_rel_manual_medical_office}}', ['sanatorium_id' => 'id']);
    }


    /**
     *    Цены
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::class, ['sanatorium_id' => 'id']);
    }

//    /**
//     *    Тип номера (Не знаю для чего она тут, но вроде не используеться)
//     * @return \yii\db\ActiveQuery
//     */
//    public function getRelSanRoomType()
//    {
//        return $this->hasMany(Medicalbase::class, ['id' => 'room_type_id'])
//            ->viaTable('{{%sanatorium_roomtype_rel_facilitiesservices}}', ['facilities_rooms_id' => 'id']);
//    }

    public function getFullAddress() {
        $text = '';
        $text .= (isset($this->company->lang)) ? $this->company->lang->title . ', '  : '';
        $text .= $this->postcode . ', ';
        $text .= (isset($this->city->lang)) ? $this->city->lang->title . ', ' : '' .
            $text .= (isset($this->country->lang)) ? $this->country->lang->title  : '' ;

        return $text;
    }

    /**
     *    Тип номера
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasMany(Roomtype::class, ['sanatorium_id' => 'id']);
    }
//
//    /**
//     *    Лечебные пакеты
//     * @return \yii\db\ActiveQuery
//     */
    public function getTreatmentPackages()
    {
        return $this->hasMany(RelSanatoriumsTreatmentPackage::class, ['sanatorium_id' => 'id']);
    }
        public function getTreatmentPackageFrontend()
    {
        return $this->hasMany(RelSanatoriumsTreatmentPackageFrontend::class, ['sanatorium_id' => 'id']);
    }


    /**
     *  Промежуточная таблица  Лечебные отделение
     * @return \yii\db\ActiveQuery
     */
    public function getRelTableSanMedOffice($medical_office_id = null)
    {
        return $this->hasMany(RelSanatoriumMedicalOffice::class,
            ['sanatorium_id' => 'id'])->where(['medical_office_id' => $medical_office_id])->all();
    }

    public function getRelTableSanMedOfficeForm($medical_office_id = null)
    {
        return $this->hasOne(RelSanatoriumMedicalOffice::class,
            ['sanatorium_id' => 'id'])->where(['medical_office_id' => $medical_office_id])->one();
    }

    /**
     *    Страна
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'location_country_id']);
    }

    /**
     *    Город
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'location_city_id']);
    }

// !!! Перенес в backend, спрашивать Андрея

//    public static function dropDownList($company_id = null)
//    {
//        $sanatorium = self::find()->enabled();
//
//        if ($company_id) {
//            $sanatorium->andWhere('company_id = :company_id', [':company_id' => $company_id]);
//        }
//
//        return ArrayHelper::map($sanatorium->all(), 'id', 'lang.title');
//    }

    /**
     * @return $this
     */
    public function getRelSanatoriumHoteloptions()
    {
        return $this->hasMany(Hoteloptions::class, ['id' => 'hoteloptions_id'])
            ->viaTable('{{%sanatorium_rel_hoteloptions}}', ['sanatorium_id' => 'id']);
    }

    /**
     *
     * Для коректного отображения чекбоксов
     */

    public function dropDownListHoteloptions() {
        $hotelOptions = $this->hasMany(RelSanatoriumHoteloptions::class, ['sanatorium_id' => 'id'])->all();

        return ArrayHelper::getColumn($hotelOptions, 'hoteloptions_id');
    }
    public function getAditionalHoteloptions() {
        $hotelOptions = $this->hasMany(RelSanatoriumHoteloptions::class, ['sanatorium_id' => 'id'])->all();

        return $hotelOptions;
    }

    /**
     *    Отзывы (подробно)
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['sanatorium_id' => 'id']);
    }


    /**
     *    Отзывы (подробно)
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     *    Отзывы (общии)
     * @return \yii\db\ActiveQuery
     */
    public function getTotalComment()
    {
        return $this->hasOne(TotalComment::class, ['sanatorium_id' => 'id']);
    }

    /**
     * Relation discount
     *
     */
    public function getDiscount()
    {
        return $this->hasMany(Discount::class, ['sanatorium_id' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getUrl($scheme = false)
    {
        return Url::toRoute(['/sanatorium/item/index', 'alias' => $this->alias], $scheme);
    }

    /**
     *
     * @return string
     */
    public function getGalleryBasePath()
    {
        return Yii::getAlias('@root') . '/frontend/' . self::fileUploadFolder;
    }

    /**
     *
     * @return string
     */
    public function getGalleryBaseUrl()
    {
        return Yii::$app->request->hostInfo . '/' . self::fileUploadFolder;
    }

    /**
     *
     * @return string
     */
    public function getGalleryLinkUrl()
    {
        $data = [];
        if (!empty($this->gallery_link)) {
            $fileNames = explode(',', $this->gallery_link);
            
            foreach ($fileNames as $key => $val) {
                if (file_exists($this->getGalleryBasePath(). '/' . $val)) {
                    $data[$key] = $this->getGalleryBaseUrl() . '/' . $val;
                }
            }
        }

        return $data;
    }

    // Дописать проверку на наличие файла
    public function getImageLink($attribute) {

        if (isset($this->$attribute)) {
            if (file_exists($this->getGalleryBasePath(). '/' .$this->$attribute)) {
                return $this->getGalleryBaseUrl(). '/' .$this->$attribute;
            }
        }
    }

    // Дописать проверку на наличие файла
    public function getBackgroundImageLink($attribute) {

        if (isset($this->$attribute) && $this->$attribute) {
            if (file_exists($this->getGalleryBasePath(). '/' .$this->$attribute)) {
                return '/frontend/' . self::fileUploadFolder . '/' .$this->$attribute;
            }
        }
    }


    /**
     *  Формирование полей для выборки для виджета Select2
     * @return array
     */

    public static function getDataForSelect2() {
        $sanatoriums = self::find_base()->enabled()->all();
        $data = [];
        if ($sanatoriums) {
            foreach($sanatoriums as $sanatorium) {
                $text = (isset($sanatorium->lang)) ? $sanatorium->lang->title . ' ': '';
                $text .= (isset($sanatorium->city->lang)) ? $sanatorium->city->lang->title . ' ' : '';
                $text .= (isset($sanatorium->country->lang)) ? $sanatorium->country->lang->title . ' ' : '';
                $data[$sanatorium->id] = $text;
            }
        }
        return $data;
    }

    public function getAdminUser()
    {
        return $this->hasOne(User::className(), ['sanatorium_id' => 'id'])
            ->joinWith('profile')
            ->andWhere(['fv_user.group_id' => 4]);
    }

    /**
     * @return mixed
     */
    public function getSelectedItems()
    {
        return explode(',', $this->accept_bank_cards);
    }

    public function getImgSize($size, $attribure)
    {
         if ( isset($this->$attribure) && file_exists($this->getGalleryBasePath(). "/thumbs/thumb-{$size}." . $this->$attribure))  {
             return $this->getGalleryBaseUrl(). "/thumbs/thumb-{$size}." . $this->$attribure;
         } else  {

             return $this->getImageLink($attribure);
         }
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownList() {
        return ArrayHelper::merge(['0' => ''], ArrayHelper::map(self::find_base()->enabled()->all(), 'id', 'lang.title'));
    }

    
}
