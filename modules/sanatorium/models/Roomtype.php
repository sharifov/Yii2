<?php

namespace thread\modules\sanatorium\models;

use admin\modules\manual\models\SceneryFromRoom;
use DateInterval;
use DatePeriod;
use DateTime;
use frontend\components\BasketBooking;
use frontend\components\SearchParams;
use thread\modules\manual\models\Facilitiesrooms;
use thread\modules\manual\models\Medicalbase;
use thread\modules\manual\models\Rooms;
use frontend\modules\sanatorium\models\Roomtype as RoomtypeFrontend;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property mixed image_link
 */
class Roomtype extends \thread\models\ActiveRecord
{

    private $searchParams = null;
    const fileUploadFolder = 'upload/sanatoriums/roomtype';

    public $BANK_CARD = null;

    const TYPE_VIEW_GARDEN = 'Garden view';
    const TYPE_VIEW_POOL = 'Pool view';
    const TYPE_VIEW_PARK = 'Park view';
    const TYPE_VIEW_MOUNTAIN = 'Mountain view';
    const TYPE_VIEW_SEA = 'Sea view';
    const TYPE_VIEW_RIVER = 'River view';
    const TYPE_VIEW_FOREST = 'Forest view';
    const TYPE_VIEW_LAKE = 'Lake view';
    const TYPE_VIEW_STREET = 'Street view';

    const FORM_NUMBER_ROOMS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
    const FORM_NUMBER_CHILDREN = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];
    const FORM_NUMBER_ADULTS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27];

    const EXTRA_BED_NAME = 'with_extra_bed';

    static $dateIntervalForSanatorium = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_room_type}}';
    }

    public function getListTreatmentPackagesFrontend($personParams, $numberNights = null)
    {
        $RoomtypeFrontend = new RoomtypeFrontend();
        $sanat = $this->sanatorium;


        return $RoomtypeFrontend->getListTreatmentPackages($personParams, $sanat, $numberNights = null);
    }


    public function rules()
    {
        return [
            [
                [
                    'manual_rooms_id',
                    'sanatorium_id',
                ],
                'required'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'create_time',
                    'manual_rooms_id',
                    'sanatorium_id',
                    'number_rooms',
                    'number_rooms_booking',
                    'extra_bad',
                    'room_size',
                    'number_extra_bad',
                    'update_time',
                    'number_people_in_rooms',
                    'scenery_from_room_id'
                ],
                'integer'
            ],
            [
                ['number_rooms', 'number_rooms_booking', 'room_size', 'roomtype-width_bed', 'number_people_in_rooms', 'number_extra_bad'],
                'default',
                'value' => 0
            ],
            [['image_link'], 'string', 'max' => 255],
            [['width_bed'], 'string', 'max' => 128],
            [['number_rooms'], 'integer', 'min' => 0],

//            [['room_view'], 'in', 'range' => array_keys(static::getRoomView())],

            [['room_type_ids', 'gallery_link'], 'safe'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'manual_rooms_id' => Yii::t('sanatorium', 'manual_rooms_id'),
            'sanatorium_id' => Yii::t('sanatorium', 'sanatorium_id'),
            'number_rooms' => Yii::t('sanatorium', 'number_rooms'),
            'number_rooms_booking' => Yii::t('sanatorium', 'number_rooms_booking'),
            'width_bed' => Yii::t('sanatorium', 'width_bed'),
            'extra_bad' => Yii::t('sanatorium', 'extra_bad'),
            'room_size' => Yii::t('sanatorium', 'room_size'),
            'number_extra_bad' => Yii::t('sanatorium', 'number_extra_bad'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'number_people_in_rooms' => Yii::t('app', 'number_people_in_rooms'),
            'image_link' => Yii::t('app', 'image_link'),
            'gallery_link' => Yii::t('app', 'gallery_link'),
//            'room_view' => Yii::t('sanatorium', 'Room view'),
            'scenery_from_room_id' => Yii::t('sanatorium', 'Room view'),
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
                'manual_rooms_id',
                'number_rooms',
                'number_rooms_booking',
                'width_bed',
                'extra_bad',
                'room_size',
                'number_extra_bad',
                'number_extra_bad',
                'sanatorium_id',
                'room_type_ids',
                'number_people_in_rooms',
                'image_link',
                'gallery_link',
                'scenery_from_room_id',
                'published'
            ],
        ];
    }

    /**
     *
     * вид оз номера
     */

    public function getSceneryFromRoom()
    {
        return $this->hasOne(SceneryFromRoom::class, ['id' => 'scenery_from_room_id']);
    }


    /**
     * Санаторий
     * @return \yii\db\ActiveQuery
     */

    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    public function getSanatoriumFrontend()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }


    /**
     *
     * manual roomtype
     */

    public function getRooms()
    {
        return $this->hasOne(Rooms::class, ['id' => 'manual_rooms_id']);
    }


    public function getLang()
    {
        return $this->hasOne(RoomtypeLang::class, ['rid' => 'id']);
    }

    public function getRelFacilitiesRooms()
    {
        return $this->hasMany(Medicalbase::class, ['id' => 'facilities_rooms_id'])
            ->viaTable('{{%sanatorium_roomtype_rel_facilitiesservices}}', ['room_type_id' => 'id']);
    }

    public function getRoomsFacilities()
    {
        return $this->hasMany(Facilitiesrooms::class, ['id' => 'facilities_rooms_id'])
            ->viaTable('{{%sanatorium_roomtype_rel_facilitiesservices}}', ['room_type_id' => 'id']);
    }

    /**
     *
     * Для коректного отображения чекбоксов
     */

    public function dropDownListFacilitiesRooms()
    {
        $facielRooms = $this->hasMany(RelRoomTypeFacilitiesRooms::class, ['room_type_id' => 'id'])->all();
        return ArrayHelper::getColumn($facielRooms, 'facilities_rooms_id');
    }

    /**
     * @param null $sanatorium_id
     * @return array
     */
    public static function dropDownList($sanatorium_id = null)
    {

        $rooms = self::find_base()->undeleted()->andWhere(['sanatorium_id' => $sanatorium_id])->enabled()->all();
        $list = [];

        foreach ($rooms as $room) {
            $list[$room->id] = $room->getTitleWithViewRoom();
        }

        return $list;
    }

    public static function dropDownListModel($sanatorium_id = null)
    {
        return self::find_base()->undeleted()->andWhere(['sanatorium_id' => $sanatorium_id])->all();
    }


    /**
     *
     * @return string
     */
    public function getImageBasePath()
    {
        return Yii::getAlias('@root') . '/frontend/' . self::fileUploadFolder;
    }

    /**
     *
     * @return string
     */
    public function getImageBaseUrl()
    {

        return Yii::$app->request->hostInfo . '/' . self::fileUploadFolder;
    }

    /**
     *
     * @param string $size
     * @return string
     */
    public function getImageLinkUrl($size = "thumb")
    {
        return $this->getImageBaseUrl() . '/' . $this->image_link;
        if ($this->image_link) {
            $thumb = $this->getImageBasePath() . '/thumbs/thumb-222x148.' . $this->image_link;
            if (file_exists($thumb) && $size == 'thumb') {
                return $this->getImageBaseUrl() . '/thumbs/thumb-222x148.' . $this->image_link;
            } else {
                return $this->getImageBaseUrl() . '/' . $this->image_link;
            }
        } else {
            return '';
        }
    }

    public function getGalleryLinkUrl($size = 'thumb')
    {
        $data = [];
        if (!empty($this->gallery_link)) {
            $fileNames = explode(',', $this->gallery_link);

            foreach ($fileNames as $key => $val) {

                $thumb = $this->getImageBasePath() . '/thumbs/thumb-222x148.' . $val;
                if (file_exists($thumb) && $size == 'thumb') {
                    $data[$key] = $this->getImageBaseUrl() . '/thumbs/thumb-222x148.' . $val;
                } else {
                    $data[$key] = $this->getImageBaseUrl() . '/' . $val;
                }

            }
        }

        return $data;
    }

//    /**
//     * @return array
//     */
//    public static function getRoomView()
//    {
//        return [
//            self::TYPE_VIEW_GARDEN => Yii::t('sanatorium', 'Garden view'),
//            self::TYPE_VIEW_POOL => Yii::t('sanatorium', 'Pool view'),
//            self::TYPE_VIEW_PARK => Yii::t('sanatorium', 'Park view'),
//            self::TYPE_VIEW_MOUNTAIN => Yii::t('sanatorium', 'Mountain view'),
//            self::TYPE_VIEW_SEA => Yii::t('sanatorium', 'Sea view'),
//            self::TYPE_VIEW_RIVER => Yii::t('sanatorium', 'River view'),
//            self::TYPE_VIEW_FOREST => Yii::t('sanatorium', 'Forest view'),
//            self::TYPE_VIEW_LAKE => Yii::t('sanatorium', 'Lake view'),
//            self::TYPE_VIEW_STREET => Yii::t('sanatorium', 'Street view'),
//        ];
//    }

    /**
     * * Получаем стоймость номера
     *
     * @param $numer_people
     * @param $type_food
     * @param $age
     * @param string $standard_bed
     * @param string $extra_bed
     * @param null $dateFrom
     * @param null $dateTo
     * @return int (Возаращает цену)
     */

    public function getPriceWithParams(
        $number_people,
        $dateFrom = null,
        $dateTo = null,
        $type_food = 'FBT',
        $age = 'Adult',
        $standard_bed = '1',
        $extra_bed = '0',
        $ceil = true
    )
    {
        $dateFrom = ($dateFrom) ? $dateFrom : $this->getSearchParams()->getParamDateFrom();
        $dateTo = ($dateTo) ? $dateTo : $this->getSearchParams()->getParamDateTo();

        $number_people = ($this->number_people_in_rooms < $number_people) ? $this->number_people_in_rooms : $number_people;
        $price = 0;


        /** Если что раскешировать) */
        $dates = $this->getDateIntervalForSanatorium($dateFrom, $dateTo);

//print_r($dates); 
//echo 'and'." $dateFrom $dateTo $number_people ";
        $daysTotal=0;
        $pricePerDay=0;
        if ($dates) {
            foreach ($dates as $date) {

               // if ($date["dateTo"] == $date["dateFrom"]) continue;


                /** @var Получаем datesPriceId $priceModel */
                $datePriceModel = DatePrice::findByDates($this->sanatorium_id, $date[BasketBooking::DATE_FROM], $date[BasketBooking::DATE_TO]);
               // echo 'mod: ';
               // print_r($datePriceModel); 
                

                $priceModel = $this->hasOne(Price::class, [
                    'sanatorium_room_type_id' => 'id',
                ])
                    ->andWhere([
                        'type_food' => $type_food,
//                        'age' => $age,
                        'standard_bed' => (string)$standard_bed,
                        'extra_bed' => (string)$extra_bed,
                        'number_people' => $number_people,
                        'date_price_id' => (isset($datePriceModel['id'])) ? $datePriceModel['id'] : null
                    ])
                    ->enabled();


                if ($age === 'Adult' || $age >= Price::AGE_NUMBER_ADULT) {
                    $priceModel->andWhere(['children_age_id' => null]);
                }


                if ($age < Price::AGE_NUMBER_ADULT) {
//                    TODO:: ВОЗРАСТ РАСЧИТЫВАЕТЬСЯ ВКЛЮЧИТЕЛЬНО !
                    $priceModel->innerJoin(ChildrenAge::tableName(), ChildrenAge::tableName() . '.id = ' . Price::tableName() . '.children_age_id')
                        ->andWhere(['<=', ChildrenAge::tableName() . '.age_begin', $age])
                        ->andWhere(['>=', ChildrenAge::tableName() . '.age_end', $age])
                        ->andWhere(
                            [
                                ChildrenAge::tableName() . '.published' => '1',
                                ChildrenAge::tableName() . '.deleted' => '0',
                            ]
                        );

                }
                $priceModel = $priceModel->one();
                //echo "PRICE MODEL";
                //print_r($priceModel);
               // echo "ENDPRICE MODEL";


                if ($priceModel) {
                    $dateInterval = BasketBooking::getTotalNumbersNightsForPricesStatic($date[BasketBooking::DATE_FROM], $date[BasketBooking::DATE_TO]);

                    $daysTotal+=$dateInterval;
                    $pricePerDay=$priceModel->price;
                    
                    $price += ($priceModel->price * $dateInterval);
                    //echo "dety: $price -> $priceModel->price * $dateInterval";
                } else {
                    $price = 0;
                    break;
                }

            }
        }
        
       // $difff=$daysTotal-$this->adjustDateInterval($daysTotal);
        //  exit($this->sanatorium_id."here".$daysTotal.' '.$difff.' '.$pricePerDay);
        //if ($diff>0){
        //    $price-=$pricePerDay*$difff;
        //}
        //exit("price:".$price);

//exit("here".(($ceil === true) ? ceil($price) : $price));
        return ($ceil === true) ? $price : $price;
    }

    protected function getDateIntervalForSanatorium($dateFrom = null, $dateTo = null)
    {
        $dateFrom = ($dateFrom) ? $dateFrom : $this->getSearchParams()->getParamDateFrom();
        $dateTo = ($dateTo) ? $dateTo : $this->getSearchParams()->getParamDateTo();

        if (self::$dateIntervalForSanatorium === null || ($dateFrom !== null && $dateTo !== null)) {
            self::$dateIntervalForSanatorium = BasketBooking::getDatesInterval(
                $this->sanatorium_id,
                $dateFrom,
                $dateTo
            );


            $dates = self::$dateIntervalForSanatorium;


        }


        return self::$dateIntervalForSanatorium;
    }


    /** TODO:: склеить с getPriceWithParams  */
    /**
     * @param $number_people
     * @param null $dateFrom
     * @param null $dateTo
     * @param string $type_food
     * @param string $age
     * @param string $standard_bed
     * @param string $extra_bed
     * @return null
     */
    public function getPriceModelWithParams(
        $number_people,
        $dateFrom = null,
        $dateTo = null,
        $type_food = 'FBT',
        $age = 'Adult',
        $standard_bed = '1',
        $extra_bed = '0'
    )
    {
        $dateFrom = ($dateFrom) ? $dateFrom : $this->getSearchParams()->getParamDateFrom();
        $dateTo = ($dateTo) ? $dateTo : $this->getSearchParams()->getParamDateTo();
        $number_people = ($this->number_people_in_rooms < $number_people) ? $this->number_people_in_rooms : $number_people;
        $dates = BasketBooking::getDatesInterval($this->sanatorium_id, $dateFrom, $dateTo);

        if ($dates) {
            foreach ($dates as $date) {


                /** @var Получаем datesPriceId $priceModel */
                $datePriceModel = DatePrice::findByDates($this->sanatorium_id, $date[BasketBooking::DATE_FROM], $date[BasketBooking::DATE_TO]);


                $priceModel = $this->hasOne(Price::class, [
                    'sanatorium_room_type_id' => 'id',
                ])
                    ->andWhere([
                        'type_food' => $type_food,
                        'standard_bed' => (string)$standard_bed,
                        'extra_bed' => (string)$extra_bed,
                        'number_people' => $number_people,
                        'date_price_id' => (isset($datePriceModel['id'])) ? $datePriceModel['id'] : null
                    ])
//                    ->andWhere('(begin_date <= :dateFrom && :dateFrom <= end_date) AND (begin_date <= :dateTo && :dateTo <= end_date)')
//                    ->params([':dateFrom' => $date[BasketBooking::DATE_FROM], ':dateTo' => $date[BasketBooking::DATE_TO] ])
                    ->enabled();


                if ($age === 'Adult' || $age >= Price::AGE_NUMBER_ADULT) {
                    $priceModel->andWhere(['children_age_id' => null]);
                }

                if ($age < Price::AGE_NUMBER_ADULT) {
                    $priceModel->innerJoin(ChildrenAge::tableName(), ChildrenAge::tableName() . '.id = ' . Price::tableName() . '.children_age_id')
                        ->andWhere(['<=', ChildrenAge::tableName() . '.age_begin', $age])
                        ->andWhere(['>=', ChildrenAge::tableName() . '.age_end', $age])
                        ->andWhere(
                            [
                                ChildrenAge::tableName() . '.published' => '1',
                                ChildrenAge::tableName() . '.deleted' => '0',
                            ]
                        );
                }

                $priceModel = $priceModel->one();

                if (!$priceModel) {
                    $priceModel = null;
                    break;
                }

            }
        }

        return $priceModel;
    }


    /**
     * Список номеров dropDownList
     */
    public static function formNumberRooms()
    {
        $res = [];

        for ($i = 1; $i <= 4; $i++) {
            $res[$i] = Yii::t('front', 'Rooms') . ': ' . $i;
        }

        return $res;
    }

    /**
     * Список детей dropDownList
     */
    public static function formNumberChildren()
    {
        $res = [];

        for ($i = 0; $i < 4; $i++) {
            $res[$i] = Yii::t('front', 'Children') . ': ' . $i;
        }


        return $res;
    }

    /**
     * Список взрослых dropDownList
     */
    public static function formNumberAdults()
    {
        $res = [];

        for ($i = 1; $i <= 4; $i++) {
            $res[$i] = Yii::t('front', 'Adults') . ': ' . $i;
        }

        return $res;
    }


    /**
     * Получаем общее количество детей в номере всех номераз ( ! При бронировании)
     *
     * array [ 'adults' => .. , 'childrens' => ... ]
     */
    public static function getTotalNumberChildrens($roomtypes)
    {
        $adults = 0;
        $childrens = 0;

        foreach ($roomtypes as $roomtype) {
            if ($roomtype['userParams']) {
                foreach ($roomtype['userParams'] as $userParams) {
//                    if ($userParams['age'] == Price::AGE_ADULT) {
                    if ($userParams['age'] >= 18) {
                        $adults++;
                    } else {
                        $childrens++;
                    }
                }
            }
        }

        return ['adults' => $adults, 'childrens' => $childrens];
    }


    /**
     * @param $dateFrom
     * @param $dateTo
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getPriceModelWithDate($dateFrom, $dateTo)
    {
        $dateFrom = ($dateFrom) ? $dateFrom : null;
        $dateTo = ($dateTo) ? $dateTo : null;

        return $this->hasOne(Price::class, [
            'sanatorium_id' => 'sanatorium_id',
            'sanatorium_room_type_id' => 'id',
        ])->andWhere(' (begin_date <= :dateFrom && :dateFrom <= end_date) AND (begin_date <= :dateTo && :dateTo <= end_date)')
            ->params([':dateFrom' => $dateFrom, ':dateTo' => $dateTo])->one();
    }


    public function getPrice()
    {
        // придумать чтото с датами
        $dateFrom = $this->getSearchParams()->getParamDateFrom();
        $dateTo = $this->getSearchParams()->getParamDateTo();

//        т.к. Мы можем заказать несколько номеров одного типа
//        $numberPeople =  ($this->getSearchParams()->getParamNumberAdults()) ? $this->getSearchParams()->getParamNumberAdults() : 1;

        return $this->hasOne(Price::class, [
            'sanatorium_id' => 'sanatorium_id',
            'sanatorium_room_type_id' => 'id',
        ])->andWhere([
            'type_food' => 'FBT',
            'age' => 'Adult',
            'standard_bed' => '1',
            'extra_bed' => '0',
//            'number_people' => $numberPeople,
        ])->andWhere(' (begin_date <= :dateFrom && :dateFrom <= end_date) AND (begin_date <= :dateTo && :dateTo <= end_date)')
            ->params([':dateFrom' => $dateFrom, ':dateTo' => $dateTo])->enabled();
    }


    /**
     * @return SearchParams|null
     */
    public function getSearchParams()
    {
        if (!$this->searchParams) {
            $this->searchParams = new SearchParams();
        }
        return $this->searchParams;
    }


    /**
     * Название номера (тип номера - с видом на...)
     * @return string
     */

    public function getTitleWithViewRoom()
    {
        $title = (isset($this->rooms->lang)) ? $this->rooms->lang->title : '';
        $viewRoom = (isset($this->sceneryFromRoom->lang)) ? " - " . $this->sceneryFromRoom->lang->title : '';

        return $title . $viewRoom;
    }

    
    /**************
     * NEW
     ***************/

    /**
     * * Получаем стоймость номера
     *
     * @param $numer_people
     * @param $type_food
     * @param $age
     * @param string $standard_bed
     * @param string $extra_bed
     * @param null $dateFrom
     * @param null $dateTo
     * @return int (Возаращает цену)
     */
public function getRealIpAddr()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip;
    }

    public function getPriceWithParamsNew(
        $number_people,
        $dateFrom = null,
        $dateTo = null,
        array $paramsQuery,
        $ceil = true
//        $type_food = 'FBT',
//        $age = 'Adult',
//        $standard_bed = '1',
//        $extra_bed = '0',
    )
    {
        $dateFrom = ($dateFrom) ? $dateFrom : $this->getSearchParams()->getParamDateFrom();
        $dateTo = ($dateTo) ? $dateTo : $this->getSearchParams()->getParamDateTo();

        $number_people = ($this->number_people_in_rooms < $number_people) ? $this->number_people_in_rooms : $number_people;
        $price = 0;


        $age = isset($paramsQuery['age']) ? $paramsQuery['age'] : null;


        /** Если что раскешировать) */
        $dates = $this->getDateIntervalForSanatorium($dateFrom, $dateTo);
        $total_p = count($dates);
        $count_periods = $total_p;

        if ($dates) {
            //falkensteiner-hotel-grand-medspa-marienbad discount
            $sanatorium_falkensteiner_id = 58;
            $dateTo_discount = new \DateTime($dateTo);
            $dateFrom_discount = new \DateTime($dateFrom);
            $dateAugust = new \DateTime('2017-08-31');
            $difference = $dateTo_discount->diff($dateFrom_discount);
            $difference_days = (int)floor($difference->days / 7);
            //end

            usort($dates, function ($a1, $a2){
                $v1 = strtotime($a1['dateFrom']);
                $v2 = strtotime($a2['dateFrom']);
                return $v1 - $v2;
            });
            $interval = [];
            foreach ($dates as $kk=>$date) {
                if ($kk+1==$count_periods&&$date["dateFrom"]==$date["dateTo"]){
                    break;
                }

                 $i_jump = $kk?1:0;
                if ($total_p > 1) {

                    $i_jump = 0;
                    $total_p--;

                } else {
                    $i_jump = 1;
                }

                /** @var Получаем datesPriceId $priceModel */
                $datePriceModel = DatePrice::findByDates($this->sanatorium_id, $date[BasketBooking::DATE_FROM], $date[BasketBooking::DATE_TO]);

                $tempParamQuery = ArrayHelper::merge($paramsQuery,
                    [
//                        'type_food' => $type_food,
//                        'age' => $age,
//                        'standard_bed' => (string)$standard_bed,
//                        'extra_bed' => (string)$extra_bed,
                        'number_people' => $number_people,
                        'date_price_id' => (isset($datePriceModel['id'])) ? $datePriceModel['id'] : null
                    ]);
                $tempParamQuery['standard_bed'] = (string)$tempParamQuery['standard_bed'];
                $tempParamQuery['extra_bed'] = (string)$tempParamQuery['extra_bed'];
                unset($tempParamQuery['age']);
                foreach ($this["searchParams"]->params["lRooms"][0] as $item){
                    if ($item["lAge"]!='Adult'){
                        if ($item["lAge"]<Price::AGE_NUMBER_ADULT){
                            $tempParamQuery['number_people'] = $tempParamQuery['number_people']-1;
                            break;
                        }
                    }
                }
                $priceModel = $this->hasOne(Price::class, [
                    'sanatorium_room_type_id' => 'id',
                ])
                    ->andWhere($tempParamQuery)
                    ->enabled();

                if ($age === 'Adult' || $age >= Price::AGE_NUMBER_ADULT) {
                    $priceModel->andWhere(['children_age_id' => null]);
                }

                if ($age < Price::AGE_NUMBER_ADULT) {
                    $tempParamQuery['number_people'] = 2;
                    $price_child = $this->hasOne(Price::class, [
                        'sanatorium_room_type_id' => 'id',
                    ])
                        ->andWhere($tempParamQuery)
                        ->enabled();

//                    TODO:: ВОЗРАСТ РАСЧИТЫВАЕТЬСЯ ВКЛЮЧИТЕЛЬНО !
                    $price_child->innerJoin(ChildrenAge::tableName(), ChildrenAge::tableName() . '.id = ' . Price::tableName() . '.children_age_id')
                        ->andWhere(['<=', ChildrenAge::tableName() . '.age_begin', $age])
                        ->andWhere(['>=', ChildrenAge::tableName() . '.age_end', $age])
                        ->andWhere(
                            [
                                ChildrenAge::tableName() . '.published' => '1',
                                ChildrenAge::tableName() . '.deleted' => '0',
                            ]
                        );

                }

                $priceModel = $priceModel->one();
                if ($age < Price::AGE_NUMBER_ADULT){
                    $price_child = $price_child->one();
                    $priceModel->price = $price_child->price;
                }

                $this->BANK_CARD = $priceModel->bank_card;
                if ($priceModel) {
                    $dateInterval = BasketBooking::getTotalNumbersNightsForPricesStatic($date[BasketBooking::DATE_FROM], $date[BasketBooking::DATE_TO], $i_jump);
                    $price += ($priceModel->price * $dateInterval);
                    $interval[] = [
                        'month' => (int)date('m', strtotime($date['dateFrom'])),
                        'daysCount' => $dateInterval,
                        'pricePerDay' => (float)$priceModel->price
                    ];
                } else {
                    $price = 0;
                    break;
                }
            }
        }

        return [
            'price' => $price,
            'interval' => $interval
        ];
    }

}
