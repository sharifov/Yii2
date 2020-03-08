<?php

namespace thread\modules\sanatorium\models;

use frontend\components\SearchParams;
use thread\modules\manual\models\TreatmentPackage;
use Yii;
use yii\helpers\Url;

/**
 * Class Page
 * 
 * @package frontend\modules\page\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class RelSanatoriumsTreatmentPackageFrontend extends RelSanatoriumsTreatmentPackage {

    /**
     *  Переопределен или нет (использывать default значения treatment package table)
     * @return array
     */
    private $overridden = null;
    private $searchParams = null;

    /**
     * 
     * @return array
     */
    public function behaviors() {
        return [];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [];
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [];
    }

    /**
     * Лечебные пакеты
     * @return array
     */
    public function getTreatmentPackages() {
        return $this->hasOne(TreatmentPackage::class, ['id' => 'treatment_package_id']);
    }

    /**
     * Переопределяем получения атрибутов
     *
     * @return array
     */
    public function getViewAttribute($attribute, $lang = null) {
        // init и  Проверяем переопределен он или нет
        if ($this->overridden === null) {
            $this->overridden = ( (!$this->value) && (!$this->type) ) ? true : false;
        }

        // берем нагло из lang
        if ($lang) {
            return (isset($this->treatmentPackages->lang->$attribute)) ? $this->treatmentPackages->lang->$attribute : '';
        }

        if ($this->overridden) {
            return (isset($this->$attribute)) ? $this->$attribute : '';
        } else {
            return (isset($this->treatmentPackages
                            ->$attribute)) ? $this->treatmentPackages->$attribute : '';
        }
    }

    public function getNumberPackage($datePeriod = null) {
        $numberDays = ($datePeriod) ? $datePeriod : $this->getSearchParams()->getTotalNumbersNights();

        if ($this->whole_stay == 1) {
            $numberDays = 1;
        }

        // Переопределен
        if ($this->type || $this->value) {
            return floor(($this->type) ? $this->type : $this->value * $numberDays);
        } else {
            return floor(($this->treatmentPackages->type) ? $this->treatmentPackages->type : $this->treatmentPackages->value * $numberDays);
        }
    }

    /**
     *
     * @return string
     */
    public function getImageLink() {

        return (isset($this->treatmentPackages->image_link) && $this->treatmentPackages->image_link && is_file($this->getGalleryBasePath() . '/' . $this->treatmentPackages->image_link)) ? '/' . TreatmentPackage::fileUploadFolder . '/' . $this->treatmentPackages->image_link : '';
    }

    /**
     *
     * @return string
     */
    public function getGalleryBasePath() {
        return Yii::getAlias('@root') . '/frontend/' . TreatmentPackage::fileUploadFolder;
    }

    public function getSearchParams() {
        if (!$this->searchParams) {
            $this->searchParams = new SearchParams();
        }
        return $this->searchParams;
    }

    /**
     * Получить список направление лечения

      @return [
      'title' => '123',
      'imgLink' => '123',
      ]
     */
    public static function getListTreatmentPackageRoom($type_food, $age, $dateInterval, $sanatoriumId) {

        $typeFoodList = Price::TypeBookingParams;
        $textTypeFood = (isset($typeFoodList[$type_food])) ? $typeFoodList[$type_food] : null;
        $treatmentPackage = [];

        $treatmentPackage[] = [
            'imgLink' => TreatmentPackage::imgNights,
            'title' => $dateInterval . ' ' . Yii::t('front', 'nights')
        ];

        $treatmentPackage[] = [
            'imgLink' => TreatmentPackage::imgFood,
            'title' => TreatmentPackage::getNumberDaysFood($textTypeFood, $dateInterval),
        ];

        if (array_search($textTypeFood, Roomtype::ARRAY_TYPE_FOOD_WITH_PROCEDURE) !== false) {
            $relSanPackage = self::find_base()->andWhere(['sanatorium_id' => $sanatoriumId])->all();

            if ($relSanPackage) {
                foreach ($relSanPackage as $package) {

                    $treatmentPackage[] = [
                        'imgLink' => $package->getImageLink(),
                        'title' =>  $package->getNumberPackage($dateInterval). ' '. $package->getViewAttribute('title', 'lang'),
                    ];
                }
            }
        }

        return $treatmentPackage;
    }

}
