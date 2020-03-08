<?php

namespace thread\modules\sanatorium\models;

use frontend\components\BasketBooking;
use frontend\components\SearchParams;
use frontend\components\Selection;
use thread\modules\manual\models\Rooms;
use Yii;
use yii\db\mssql\PDO;

class Price extends \thread\models\ActiveRecord
{
    const PriceName = 'PriceTable';

    /**
     * Список цен (на главной странице)
     * ключ - Цена ОТ
     * занчение - Цена До
     *
     * @inheritdoc
     */
    const priceList = [
        100 => 200,
        200 => 500,
        500 => 1000,
        1000 => 2000
    ];

    /**
     * Типы питания
     */

    const TYPE_FOOD_FBT = 'FBT';
    const TYPE_FOOD_HBT = 'HBT';
    const TYPE_FOOD_HB = 'HB';
    const TYPE_FOOD_FB = 'FB';


    const AGE_NUMBER_ADULT = 18; // >= 18
    /**
     * Возраст
     */
    const AGE_ADULT = 'Adult'; // >= 18
    const AGE_YOUNG = 'Young'; // 17 - 12
    const AGE_TEEN = 'Teen';   // 11 - 6
    const AGE_CHILD = 'Child'; // 2 - 5

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_prices}}';
    }


    public function rules()
    {
        return [
//            [['begin_date', 'end_date'], 'required'],
            [
                ['published', 'deleted', 'extra_bed', 'standard_bed', 'bank_card'],
                'in',
                'range' => array_keys(static::statusKeyRange())
            ],
            [['type_food'], 'in', 'range' => array_keys(static::statusTypeFood())],
            [['age'], 'in', 'range' => array_keys(static::statusTypeFood())],
            [
                [
                    'create_time',
                    'number_people',
                    'update_time',
                    'sanatorium_id',
                    'sanatorium_room_type_id',
                    'manual_room_id',
                    'min_days',
                    'number_rooms',
                    'children_age_id',
                    'number_extra_bed'
                ],
                'integer'
            ],
            [['bank_card', 'min_days', 'number_rooms', 'number_extra_bed'], 'default', 'value' => 0],

//            [['begin_date', 'end_date'], 'date', 'format' => 'php:Y-m-d'],

            [['price', 'price_euro'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'sanatorium_room_type_id' => Yii::t('app', 'sanatorium_room_type_id'),
            'manual_room_id' => Yii::t('app', 'manual_room_id'),
//            'begin_date' => Yii::t('app', 'begin_date'),
//            'end_date' => Yii::t('app', 'end_date'),
            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'price' => Yii::t('app', 'price'),
            'extra_bed' => Yii::t('app', 'extra_bed'),
            'standard_bed' => Yii::t('app', 'standard_bed'),
            'type_food' => Yii::t('app', 'type_food'),
            'age' => Yii::t('app', 'age'),
            'min_days' => Yii::t('app', 'min_days'),
            'bank_card' => Yii::t('app', 'bank_card'),
            'number_rooms' => Yii::t('app', 'number_rooms'),
            'number_people' => Yii::t('app', 'number_people'),
            'price_euro' => Yii::t('app', 'price_euro'),
            'children_age_id' => Yii::t('app', 'children_age_id'),
        ];
    }

    /**
     * @return array
     */
    public static function statusTypeFood()
    {
        return [
            self::TYPE_FOOD_FBT,
            self::TYPE_FOOD_HBT,
            self::TYPE_FOOD_HB,
        ];
    }


    /**
     * @return array
     */
    public static function statusAge()
    {
        return [
            self::AGE_ADULT,
            self::AGE_TEEN,
            self::AGE_CHILD,
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
            'date' => [
//                'begin_date',
//                'end_date',
                'bank_card',
                'sanatorium_id',
                'number_rooms',
                'min_days',
                'number_people'
            ],
            'save-general-model' => ['bank_card', 'number_rooms', 'min_days', 'number_people'],
            'backend' => [
                'sanatorium_id',
                'sanatorium_room_type_id',
                'manual_room_id',
//                'begin_date',
//                'end_date',
                'published',
                'price',
                'extra_bed',
                'standard_bed',
                'type_food',
                'age',
                'min_days',
                'bank_card',
                'number_rooms',
                'price_euro',
                'children_age_id',
                'number_extra_bed'
//                'number_people',
            ],
        ];
    }


    /**
     *   (Вид номеров)
     * @return \yii\db\ActiveQuery
     */
    public function getChildrenAge()
    {
        return $this->hasOne(ChildrenAge::class, ['id' => 'children_age_id']);
    }

    /**
     *   (Вид номеров)
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasOne(Rooms::class, ['id' => 'manual_room_id']);
    }

    /**
     *  Тип номера санатория!
     * @return \yii\db\ActiveQuery
     */
    public function getSanRoomType()
    {
        return $this->hasOne(Roomtype::class, ['id' => 'sanatorium_room_type_id']);
    }

    /**
     *   Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }


    /**
     *
     * Получаем возраст
     *
     */
    public static function getConstAgeInNumber($number)
    {

        if ($number) {

            if (2 <= $number && $number <= 5) {
                return self::AGE_CHILD;
            }

            if (6 <= $number && $number <= 11) {
                return self::AGE_TEEN;
            }
            if (12 <= $number && $number <= 17) {
                return self::AGE_YOUNG;
            }

            if ($number > 17 || $number < 2) {
                return self::AGE_ADULT;
            }
        }

        // Дети бесплатно
        if ($number < 2) {
            return false;
        }

    }

//
//    /**
//     *
//     *  Убрать потом верхний возраст Получаем возраст
//     *
//     */
//    public static function getAgeInNumber($number)
//    {
//
//        if (2 <= $number && $number <= 5) {
//            return self::AGE_CHILD;
//        }
//
//        if (6 <= $number && $number <= 11) {
//            return self::AGE_TEEN;
//        }
//        if (12 <= $number && $number <= 17) {
//            return self::AGE_YOUNG;
//        }
//
//        if ($number > 17 || $number < 2) {
//            return self::AGE_ADULT;
//        }
//
//        // Дети бесплатно
//        if ($number < 2) {
//            return self::AGE_ADULT;
//        }
//
//    }


    /**
     * Получаем количество
     * @param $sanatorium_id
     * @param $dateFrom
     * @param null $dateTo
     * @param int $searchParams
     *  0 - взрослые
     *  1 - дети
     *
     * @param null $numberPeople
     * @return array
     */

    public static function getMaxNumberPeopleInRoomWithPrice($sanatorium_id, $dateFrom, $dateTo = null, $searchParams = 0, $numberPeople = null)
    {
        $connection = Yii::$app->db;
        $sqlDateCondition = '';

        $searchParamCondition = "AND fv_sanatorium_prices.children_age_id IS NULL";

        if ($searchParams === 1) {
            $searchParamCondition = "  AND fv_sanatorium_prices.children_age_id NOT NULL ";
        }

        $numberPeople = ($numberPeople === null) ? 1 : $numberPeople;


        $numberNights = ($dateFrom && $dateTo) ? BasketBooking::getTotalNumbersNightsStatic($dateFrom, $dateTo) : 1;

        $command = $connection->createCommand("


        SELECT *  FROM (
                SELECT fv_sanatorium_prices.sanatorium_id,
                    fv_sanatorium_prices.sanatorium_room_type_id,
                    fv_sanatorium_room_type.id,
                    fv_sanatorium_room_type.number_people_in_rooms,
                    fv_sanatorium_prices.number_rooms as number_rooms,
                    booking_room,
                    IF (
                    fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room) < 0,
                    0,
                    fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room)
                    )
                    as free_rooms ,
                    IF (
                    (fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room)) * number_people_in_rooms < 0,
                    0,
                    (fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room)) * number_people_in_rooms
                    )
                    as countMember,
                    :numberNights as numberNights,
                    fv_sanatorium_prices.number_people,
                    fv_sanatorium_prices.extra_bed,
                    fv_sanatorium_prices.id as price_id

              
                FROM fv_sanatorium_dates_price
              
                -- Цены
                INNER JOIN fv_sanatorium_prices ON fv_sanatorium_prices.date_price_id = fv_sanatorium_dates_price.id  
              
                -- ТИПЫ НОМЕРОВ
                INNER JOIN fv_sanatorium_room_type
                ON fv_sanatorium_prices.sanatorium_id = fv_sanatorium_room_type.sanatorium_id
                AND fv_sanatorium_room_type.id = fv_sanatorium_prices.sanatorium_room_type_id
                AND fv_sanatorium_room_type.published = '1'
                AND fv_sanatorium_room_type.deleted = '0'
                AND fv_sanatorium_prices.number_people =

                (IF ( :numberPeople > fv_sanatorium_room_type.number_people_in_rooms, fv_sanatorium_room_type.number_people_in_rooms, :numberPeople))

                -- КОЛИЧЕСТВО ЗАБРОНИРОВАНЫХ НОМЕРОВ
                LEFT JOIN (
                    SELECT fv_sanatorium_booking_basket.sanatorium_room_type_id, COUNT( fv_sanatorium_booking_basket.sanatorium_room_type_id) as booking_room
                        FROM fv_sanatorium_booking_basket
                            WHERE fv_sanatorium_booking_basket.sanatorium_booking_id IN (
                            SELECT fv_sanatorium_booking.id
                                FROM fv_sanatorium_booking
                                WHERE ( ( date_begin <= :dateFrom AND date_end >= :dateFrom) OR ( date_begin <= :dateTo AND date_end >= :dateTo) )
                                AND status <> 'cancelled' AND deleted = '0'
                            )

                GROUP BY (fv_sanatorium_booking_basket.sanatorium_room_type_id)

                ) AS booking_table ON booking_table.sanatorium_room_type_id = fv_sanatorium_prices.sanatorium_room_type_id


                WHERE fv_sanatorium_prices.sanatorium_id
                IN (
                    SELECT fv_sanatorium_sanatoriums.id
                        FROM fv_sanatorium_sanatoriums
                        WHERE id = :sanatorium_id
                )

                AND ((begin_date <= :dateFrom AND :dateFrom <= end_date ) AND (begin_date <= :dateTo AND :dateTo <= end_date ) )
                AND fv_sanatorium_prices.price > 0
                AND fv_sanatorium_prices.published = '1'
                AND fv_sanatorium_prices.deleted = '0'

                -- Т.К. первый заказ будет на взрослого


                $searchParamCondition


                ORDER BY fv_sanatorium_prices.number_people DESC, fv_sanatorium_prices.extra_bed DESC

        ) as newTable
        GROUP BY sanatorium_room_type_id

        -- Т.К изначально выборка идет на одного человека


        ");


        $command->bindParam(':dateFrom', $dateFrom, PDO::PARAM_STR);
        $command->bindParam(':dateTo', $dateTo, PDO::PARAM_STR);

        $command->bindParam(':numberNights', $numberNights, PDO::PARAM_STR);
        $command->bindParam(":sanatorium_id", $sanatorium_id, PDO::PARAM_STR);

        $command->bindParam(":numberPeople", $numberPeople, PDO::PARAM_INT);


        if ($dateTo) {
            $command->bindParam(':dateTo', $dateTo, PDO::PARAM_STR);
        }

        $query = $command->queryAll();

        $queryWithKeyRoomtypeId = [];
        if ($query) {
            foreach ($query as $q) {
                $queryWithKeyRoomtypeId[$q['sanatorium_room_type_id']] = $q;

                // if Дети то -1 т.к взросылый должен быть обязательно
                $queryWithKeyRoomtypeId[$q['sanatorium_room_type_id']]['numberPeopleWithExtraBed'] =
                    $queryWithKeyRoomtypeId[$q['sanatorium_room_type_id']]['number_people_in_rooms'] +
                    $queryWithKeyRoomtypeId[$q['sanatorium_room_type_id']]['extra_bed'];

                if ($searchParams == 1) {
                    $queryWithKeyRoomtypeId[$q['sanatorium_room_type_id']]['numberPeopleWithExtraBed']--;
                }

            }
        }

        return $queryWithKeyRoomtypeId;
    }


    /**
     * Получить количество свободных комнат на выбраную дату
     *
     * @param $sanatorium_id
     * @param $dateFrom
     * @param null $dateTo
     * @param int $searchParams
     *  0 - Стандарт Adult, FBT, standart_bed
     *  1 - взрослые Adult
     *  2 - дети !Adult
     *  3 - все
     *
     * @return array
     *
     *
     */

//      TODO :: Убрать какаху

    public static function getNumberFreeRooms($sanatorium_id, $dateFrom, $dateTo, $searchParams = 0, $numberPeople = null)
    {
        $searchParams = new SearchParams();
        $connection = Yii::$app->db;

        $searchParamCondition = "
                    AND fv_sanatorium_prices.children_age_id IS NULL
                    AND fv_sanatorium_prices.type_food = 'FBT'
                    AND fv_sanatorium_prices.standard_bed = '1'
                    AND fv_sanatorium_prices.extra_bed = '0' ";

        if ($searchParams === 1) {
            $searchParamCondition = "  AND fv_sanatorium_prices.children_age_id IS NULL ";
        } elseif ($searchParams === 2) {
            $searchParamCondition = "  AND fv_sanatorium_prices.children_age_id NOT NULL  ";
        } elseif ($searchParamCondition === 3) {
            $searchParamCondition = " ";
        }

        $roomtypes = [];
        $roomtypesKey = [];
        $queryWithKeyRoomtypeId = [];

        $datesParams = BasketBooking::getDatesInterval($sanatorium_id, $dateFrom, $dateTo);
        $numberPeople = ($numberPeople === null) ? 1 : $numberPeople;
        $numberNights = ($dateFrom && $dateTo) ? BasketBooking::getTotalNumbersNightsStatic($dateFrom, $dateTo) : 1;

        if ($datesParams) {
            foreach ($datesParams as $key => $date) {
                // т.к. эта функция используеться для проверики свободных номеров
                $command = $connection->createCommand("

              SELECT fv_sanatorium_prices.sanatorium_id,
                     fv_sanatorium_prices.sanatorium_room_type_id,
                     fv_sanatorium_room_type.number_people_in_rooms,
                     booking_room,
                     fv_sanatorium_prices.number_rooms  as number_rooms,
                     fv_sanatorium_prices.id,
                     
                      booking_room,
                       
                       -- if забронированны все номера свободных номеров 
                        IF (
                            booking_status != 'add-manager_all_rooms' OR booking_status IS NULL,
                            IF (
                                fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room) < 0,
                                0,
                                fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room)
                            ),
                            0
                        )
                        as free_rooms ,
                       
                       IF (
                            (fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room)) * number_people_in_rooms < 0,
                            0,
                            (fv_sanatorium_prices.number_rooms - IF(booking_room IS NULL, 0, booking_room)) * number_people_in_rooms
                            )
                       as countMember,
                       :numberNights as numberNights,
                       booking_status


                    FROM fv_sanatorium_dates_price
                  
                    -- Цены
                    INNER JOIN fv_sanatorium_prices ON fv_sanatorium_prices.date_price_id = fv_sanatorium_dates_price.id
                    
                        -- КОЛИЧЕСТВО ЗАБРОНИРОВАНЫХ НОМЕРОВ
                    INNER JOIN fv_sanatorium_room_type
                        ON fv_sanatorium_prices.sanatorium_id =  fv_sanatorium_room_type.sanatorium_id
                            AND fv_sanatorium_room_type.id = fv_sanatorium_prices.sanatorium_room_type_id
                            AND fv_sanatorium_room_type.published = '1'
                            AND fv_sanatorium_room_type.deleted = '0'
                            AND fv_sanatorium_prices.number_people = (IF ( :numberPeople > fv_sanatorium_room_type.number_people_in_rooms, fv_sanatorium_room_type.number_people_in_rooms, :numberPeople))


                    -- КОЛИЧЕСТВО ЗАБРОНИРОВАНЫХ НОМЕРОВ
                    LEFT JOIN (
                        
                        SELECT fv_sanatorium_booking_basket.sanatorium_room_type_id, 
                          COUNT( fv_sanatorium_booking_basket.sanatorium_room_type_id) as booking_room,
                          fv_sanatorium_booking.status as booking_status
                        
                        FROM fv_sanatorium_booking_basket
                        INNER JOIN fv_sanatorium_booking ON  fv_sanatorium_booking.id =  fv_sanatorium_booking_basket.sanatorium_booking_id
                        
                           WHERE 
                              ( date_begin >= :dateFrom AND date_begin <= :dateTo) OR ( date_end >= :dateFrom AND date_end <= :dateTo) OR   
                              ( date_begin <= :dateFrom AND date_end >= :dateFrom) OR ( date_begin <= :dateTo AND date_end >= :dateTo) 
                          
                          
                          AND status <> 'cancelled' 
                          AND fv_sanatorium_booking.deleted = '0'
                      GROUP BY fv_sanatorium_booking_basket.sanatorium_room_type_id

                    ) AS booking_table ON booking_table.sanatorium_room_type_id = fv_sanatorium_prices.sanatorium_room_type_id
                    

                    WHERE fv_sanatorium_prices.sanatorium_id = :sanatorium_id
                    AND fv_sanatorium_prices.price > 0
                    AND fv_sanatorium_prices.published = '1'
                    AND fv_sanatorium_prices.deleted = '0'

                    $searchParamCondition
                    
--                  Т.К изначально выборка идет на одного человека
                GROUP BY fv_sanatorium_prices.sanatorium_room_type_id
        ");


                $command->bindParam(':numberNights', $numberNights, PDO::PARAM_STR);
                $command->bindParam(":sanatorium_id", $sanatorium_id, PDO::PARAM_STR);

                $command->bindParam(':dateFrom', $date[BasketBooking::DATE_FROM], PDO::PARAM_STR);
                $command->bindParam(':dateTo', $date[BasketBooking::DATE_TO], PDO::PARAM_STR);
                $command->bindParam(':numberPeople', $numberPeople, PDO::PARAM_STR);


                $query = $command->queryAll();


                if ($query) {
                    foreach ($query as $q) {
                        $roomtypes[$key][$q['sanatorium_room_type_id']] = $q;
                    }
                }
            }
        }

        if ($roomtypes) {
            foreach ($roomtypes as $room) {
                foreach ($room as $roomTypeId => $roomParams) {
                    if (!isset($roomtypesKey[$roomTypeId])) {
                        $roomtypesKey[$roomTypeId] = 1;
                    } else {
                        $roomtypesKey[$roomTypeId]++;
                    }
                }
            }

            $numberSamples = count($roomtypes);

            foreach ($roomtypes[0] as $roomTypeId => $room) {
                if (isset($roomtypesKey[$roomTypeId]) && $roomtypesKey[$roomTypeId] === $numberSamples) {
                    $queryWithKeyRoomtypeId[$roomTypeId] = $room;
                }
            }

        }

        return $queryWithKeyRoomtypeId;
    }






//
//    /**
//     * Получить общее ! количество свободных комнат на выбраную дату
//     *
//     * return [
//     * total_person - - Общее количетсво человек (! БЕЗ ДОП КРОВАТЕЙ)
//     * number_rooms - Общее количетсво номров
//     * free_rooms - Количество свободных номеров
//     *
//     * ]
//     *
//     */
//
//    public static function getTotalNumberFreeRooms($sanatorium_id, $dateFrom, $dateTo = null, $numberPeople = 0, $searchParams = 0)
//    {
//        $numberPeople = ($numberPeople) ? $numberPeople : 1;
//
//
//        $roomsParams = self::getNumberFreeRooms($sanatorium_id, $dateFrom, $dateTo, $searchParams, $numberPeople);
//        $returnRoomsParams = [
//            'total_person' => 0,
//            'number_rooms' => 0,
//            'free_rooms' => 0,
//        ];
//
//        if ($roomsParams) {
//
//            foreach ($roomsParams as $room) {
//                $returnRoomsParams['total_person'] += $room['countMember'];
//                $returnRoomsParams['number_rooms'] += $room['number_rooms'];
//                $returnRoomsParams['free_rooms'] += $room['free_rooms'];
//            }
//        }
//
//        return $returnRoomsParams;
//    }

    public function beforeValidate()
    {

//        if ($this->begin_date && $this->end_date) {
//
//
//            // Получаем список id которым  не будет равна выборка
//            $modelWithCorrentDate = Price::find_base()->undeleted()->andWhere([
//                'begin_date' => $this->begin_date,
//                'end_date' => $this->end_date,
//                'sanatorium_id' => $this->sanatorium_id
//            ])->all();
//
//            if ($modelWithCorrentDate) {
//                $listWithCorrentDateId = ArrayHelper::map($modelWithCorrentDate, 'id', 'id');
//            }
//
//
//            $priceDbModels = Price::find_base()->enabled()->groupBy('begin_date, end_date')->andWhere(['sanatorium_id' => $this->sanatorium_id]);
//
//            if (isset($listWithCorrentDateId)) {
//                $priceDbModels = $priceDbModels->andWhere(['not in', 'id', $listWithCorrentDateId])->andWhere(['sanatorium_id' => $this->sanatorium_id]);
//            }
//            $priceDbModels = $priceDbModels->all();
//
//
//
//            if ($priceDbModels) {
//                foreach ($priceDbModels as $priceModel) {
//                    if (($priceModel->begin_date <= $this->begin_date) && ($priceModel->end_date >= $this->begin_date)) {
//                        $this->addError('begin_date', 'Текущая дата пересекаеться');
//                    }
//
//                    if (($priceModel->begin_date <= $this->end_date) && ($priceModel->end_date >= $this->end_date)) {
//                        $this->addError('end_date', 'Текущая дата пересекаеться');
//                    }
//                }
//
//            }
//        }
        return parent::beforeValidate();
    }


    /**
     * Т.к. считаем включительно КОЛИЧЕСТВО ДНЕЙ !!
     */

    public static function getDateInterval($dateFrom, $dateTo)
    {

        $datePeriod = 0;

        if ($dateFrom && $dateTo) {
            if (!($dateFrom instanceof \DateTime)) {
                $dateFrom = new \DateTime($dateFrom);
            }

            if (!($dateTo instanceof \DateTime)) {
                $dateTo = new \DateTime($dateTo);
            }

            $inerval = $dateTo->diff($dateFrom);
            $datePeriod = $inerval->days + 1;  // т.к. включительно
        }

        return $datePeriod;
    }


    public static function getModelWithMaxPeople($sanatorium_id, $sanatorium_room_type_id)
    {
        return self::find_base()
            ->andWhere(['sanatorium_id' => $sanatorium_id, 'sanatorium_room_type_id' => $sanatorium_room_type_id])
            ->andWhere(['<>', 'price', '0'])
            ->enabled()
            ->orderBy('number_people DESC')
            ->one();
    }


    /**
     *  [
     *      [0] => Array
     * (
     * [age] => Adult
     * [type_food] => FBT
     * [standard_bed] => 1
     * [extra_bed] => 0
     * )
     * ]
     *
     *
     * @param $params
     */
    public static function findPriceWithParams($roomId, $sanatoriumId, $dateFrom, $dateTo, $params)
    {
        $roomTypeModel = Roomtype::findById($roomId);
        $numberPeople = 0;
        $priceModel = null;
        foreach ($params as $userParam) {
            if (!$userParam['extra_bed']) {
                $numberPeople++;
            }
        }
        $firstParams = current($params);


        if ($roomTypeModel) {
            $priceModel = $roomTypeModel->getPriceModelWithParams(
                $numberPeople,
                $dateFrom,
                $dateTo,
                $firstParams['type_food'],
                $firstParams['age'],
                $firstParams['standard_bed'],
                $firstParams['extra_bed']
            );
        }

        return $priceModel;
    }

    /**
     * Получить процент скиндки
     */

    public static function getDiscountPercentage($price, $priceWithDiscount)
    {
        return ($price !== $priceWithDiscount && $priceWithDiscount !== 0)
            ? round(100 - ($priceWithDiscount / ($price / 100)),1)
            : 0;
    }


   /**
    * Получаем ближайший промежуток дат
    * @param $sanatoriumId
    */
   public function getСlosestInterval($sanatoriumId)
   {
       $datePriceModel = DatePrice::find()
           ->andWhere(['>' ,'end_date', date('Y-m-d')])
           ->andWhere(['sanatorium_id' => $sanatoriumId])
           ->orderBy('begin_date desc')
           ->undeleted()
           ->one();

       return $datePriceModel;
   }
}
