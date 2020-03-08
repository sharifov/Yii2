<?php

namespace thread\models\query;

use frontend\components\SearchParams;
use frontend\components\Selection;
use frontend\modules\sanatorium\models\Price;
use frontend\modules\sanatorium\models\Roomtype;
use frontend\modules\sanatorium\models\Sanatoriums;
use thread\models\ActiveRecord;
use thread\modules\sanatorium\models\Discount;
use thread\modules\sanatorium\models\TotalComment;
use yii\helpers\ArrayHelper;

/**
 * Class CommonQuery
 *
 * @package thread\models\query
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ActiveQuery extends \yii\db\ActiveQuery
{

    /**
     *
     * @param string $alias
     * @return \thread\models\query\ActiveQuery
     */
    public function alias($alias)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.alias = :alias', [':alias' => $alias]);
        return $this;
    }

    /**
     *
     * @return ActiveQuery
     */
    public function enabled()
    {
        return $this->published()->undeleted();
    }

    /**
     *
     * @return \thread\models\query\ActiveQuery
     */
    public function published()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.published = :published',
            [':published' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }

    /**
     *
     * @return \thread\models\query\ActiveQuery
     */
    public function unpublished()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.published = :published',
            [':published' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }

    /**
     *
     * @return \thread\models\query\ActiveQuery
     */
    public function deleted()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.deleted = :deleted', [':deleted' => ActiveRecord::STATUS_KEY_ON]);
        return $this;
    }

    /**
     *
     * @return \thread\models\query\ActiveQuery
     */
    public function undeleted()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.deleted = :deleted', [':deleted' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }

    /**
     *
     * @return \thread\models\query\ActiveQuery
     */
    public function readonly()
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.readonly = :readonly',
            [':readonly' => ActiveRecord::STATUS_KEY_OFF]);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function _lang()
    {
        return $this->andWhere(['lang' => \Yii::$app->language]);
    }

    /**
     *
     * @param integer $group_id
     * @return \thread\models\query\ActiveQuery
     */
    public function group_id($group_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.group_id = :group_id', [':group_id' => $group_id]);
        return $this;
    }

    /**
     *
     * @param integer $parent_id
     * @return \thread\models\query\ActiveQuery
     */
    public function parent_id($parent_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.parent_id = :parent_id', [':parent_id' => $parent_id]);
        return $this;
    }

    /**
     *
     * @param integer|array $id
     * @return \thread\models\query\ActiveQuery
     */
    public function byID($id)
    {
        $modelClass = $this->modelClass;

        if (is_array($id)) {
            foreach ($id as $k => $d) {
                $id[$k] = (string)$d;
            }
            $this->andWhere($modelClass::tableName() . '.id IN (' . implode(',', $id) . ')');
        } else {
            $this->andWhere($modelClass::tableName() . '.id = :id', [':id' => $id]);
        }


        return $this;
    }

    /**
     * @param array $IDs
     * @return ActiveQuery $this
     */
    public function rangeIDs(array $IDs)
    {
        $modelClass = $this->modelClass;

        $this->andWhere(['in', $modelClass::tableName() . '.id', $IDs]);

        return $this;
    }

    /**
     * @param array $IDs
     * @return ActiveQuery $this
     */
    public function withoutIDs(array $IDs)
    {
        $modelClass = $this->modelClass;

        $this->andWhere(['not in', $modelClass::tableName() . '.id', $IDs]);

        return $this;
    }

    /**
     *
     * @return \thread\models\query\ActiveQuery
     */
    public function lang()
    {
        $modelClass = $this->modelClass . "Lang";
        $this->leftJoin($modelClass::tableName(), 'rid = id')->_lang();
        return $this;
    }

    /**
     *
     * @param string $email
     * @return \thread\models\query\ActiveQuery
     */
    public function email($email)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.email = :email', [':email' => $email]);
        return $this;
    }

    /**
     *
     * @param integer $user_id
     * @return \thread\models\query\ActiveQuery
     */
    public function user_id($user_id)
    {
        $modelClass = $this->modelClass;
        $this->andWhere($modelClass::tableName() . '.user_id = :user_id', [':user_id' => $user_id]);
        return $this;
    }


    /**
     * Вынести в новый файл!!!!!!!!!!!!!!!!!
     *
     */


    /**
     * Направление лечения (Показания к лечению)
     * @return \thread\models\query\ActiveQuery
     */

    public function getFilterAreasTreatment($params)
    {
        if ($params) {
            $this->innerJoinWith('relSanAreasTreatment')
                ->andWhere(['fv_manual_areas_treatment.id' => $params])
                ->andWhere('is_main = 1 OR is_secondary = 1');
        }
        return $this;
    }


    /**
     * Удобство номеров
     * @return \thread\models\query\ActiveQuery
     */

    public function getFilterFacilitiesRooms(Array $params)
    {
        if ($params) {
            $this->innerJoin('fv_sanatorium_room_type AS rt',
                'fv_sanatorium_sanatoriums.id = rt.sanatorium_id')
                ->innerJoin('fv_sanatorium_roomtype_rel_facilitiesservices',
                    'rt.id = fv_sanatorium_roomtype_rel_facilitiesservices.room_type_id')
                ->andWhere(['fv_sanatorium_roomtype_rel_facilitiesservices.facilities_rooms_id' => $params]);
        }
        return $this;
    }

    /**
     * Вид номера
     * @return \thread\models\query\ActiveQuery
     */

    public function getFilterViewRoom($param)
    {
        if (!empty($param)) {
            $this->innerJoin('fv_sanatorium_room_type', 'fv_sanatorium_sanatoriums.id = fv_sanatorium_room_type.sanatorium_id');
            $this->andWhere([
                'fv_sanatorium_room_type.deleted' => '0',
                'fv_sanatorium_room_type.published' => '1'
            ]);

            if ($param) {
                $this->andWhere([
                    'fv_sanatorium_room_type.manual_rooms_id' => $param,
                ]);
            }
        }
        return $this;
    }

    /**
     * Количество звезд
     * @return \thread\models\query\ActiveQuery
     */

    public function getFilterStars(Array $numberStars)
    {
        if ($numberStars) {
            $this->andWhere(['rating' => $numberStars]);
        }
        return $this;
    }

    /**
     * Цена от - до  В диапазон дат
     * @param  [priceFrom => priceTo]
     * @return \thread\models\query\ActiveQuery
     */

    public function getFilterPriceFromPriceToAndDate($price = null, $searchParams)
    {

        $dateTo = $searchParams->getParamDateTo();
        $dateFrom = $searchParams->getParamDateFrom();
        $dateInterval = $searchParams->getParamPeriodDate();
        $numberPeople = ($searchParams->getParamNumberAdults()) ? $searchParams->getParamNumberAdults() : 1;

        if (($dateFrom || $dateTo)) {

            $this->innerJoinWith('prices');

            $this->andWhere(['<=', 'begin_date', $dateFrom])
                ->andWhere(['>=', 'end_date', $dateFrom])
                ->andWhere(['<=', 'begin_date', $dateTo])
                ->andWhere(['>=', 'end_date', $dateTo])
                ->andWhere(['>', 'price_euro', 0])
                ->andWhere([
                    'type_food' => Price::DEFAULT_FOOD,
                    'age' => 'Adult',
                    'standard_bed' => '1',
                    'extra_bed' => '0',
                    'number_people' => $numberPeople,
                    Price::tableName() . '.deleted' => '0',
                    Price::tableName() . '.published' => '1'
                ]);


            if ($dateInterval && $price) {

                $firstPrice = key($price) / $dateInterval;
                $secondPrice = current($price) / $dateInterval;
                $this->andWhere(['>=', 'price_euro', $firstPrice])
                    ->andWhere(['<=', 'price_euro', $secondPrice]);
            }
        }

        return $this;
    }

    /**
     * Убираем номера с нулевой ценой
     * @param $searchParams
     * @return $this
     */
    public function getSanatoriumsWithPositivPrice($searchParams)
    {
        $numberPeople = ($searchParams->getParamNumberAdults()) ? $searchParams->getParamNumberAdults() : 1;

        $dateFrom = $searchParams->getParamDateFrom();
        $dateTo = $searchParams->getParamDateTo();

        if ($dateFrom && $dateTo) {
            $sanatoriums = Sanatoriums::find()
                ->innerJoin(Price::tableName(), Price::tableName() . '.sanatorium_id = ' . Sanatoriums::tableName() . '.id')
                ->andWhere([
                    'type_food' => Price::DEFAULT_FOOD,
                    'children_age_id' => null,
                    'standard_bed' => '1',
                    'extra_bed' => '0',
                    'number_people' => $numberPeople,
                    'price' => 0,
                    Price::tableName() . '.deleted' => '0',
                    Price::tableName() . '.published' => '1'
                ])->enabled();


            $sanatoriums =
                $sanatoriums->andWhere(['<=', 'begin_date', $dateFrom])
                    ->andWhere(['>=', 'end_date', $dateFrom])
                    ->andWhere(['<=', 'begin_date', $dateTo])
                    ->andWhere(['>=', 'end_date', $dateTo])
                    ->all();


            if ($sanatoriums) {
                $sanatoriumsId = ArrayHelper::getColumn($sanatoriums, 'id');
                $this->andWhere(['NOT IN', Sanatoriums::tableName() . '.id', $sanatoriumsId]);
            }

        }

        return $this;
    }


    /**
     *
     * @param $rooms
     *
     *    [
     *             '1(комната)' => 'nameViewBookingRoomsAdults (врослых)' => 2
     *                            'nameViewBookingRoomsChild (детских)' => 1,
     *
     *             '2(комната)' => 'nameViewBookingRoomsAdults (врослых)' => 2
     *                             'nameViewBookingRoomsChild (детских)' => 1
     *
     *
     *
     * @param $typeFood - ВЫПИЛИТЬ его! добавить его в массив rooms !!!
     * @param null $dateFrom
     * @param null $dateTo
     * @return $this
     */

//
//    public function getFilterDateFilterRoomType($rooms, $typeFood,  $dateFrom = '2111-01-01', $dateTo = '2111-01-01')
//    {
//
//        if (is_array($rooms)) {
//            $this->innerJoin(Price::tableName(),
//                Roomtype::tableName().'.id = ' .Price::tableName().'.sanatorium_room_type_id'
//            );
////                /**/ echo '<pre style="color: red">'; print_r($params); echo '</pre>'; die(); /**/
//
//                $numberRoomAdults = (isset($params[SearchParams::nameViewBookingRoomsAdults])) ? $params[SearchParams::nameViewBookingRoomsAdults] : 999;
////                /**/ echo '<pre style="color: red">'; print_r($numberRoom); echo '</pre>'; die(); /**/
//                $this->orWhere(['>', Roomtype::tableName().'.number_people_in_rooms', $numberRoomAdults]);
//
//            }
//
////            /**/ echo '<pre style="color: red">'; print_r($numberRoomAdults); echo '</pre>'; die(); /**/
//
//            $this->andWhere(['<=', Price::tableName().'.begin_date', $dateFrom])
////                 ->andWhere(['>=', Price::tableName().'.end_date', $dateFrom])
////                 ->andWhere(['<=', Price::tableName().'.begin_date', $dateTo])
//                 ->andWhere(['>=', Price::tableName().'.end_date', $dateTo]);
////        }
//
//
////        if ( $dateFrom || $dateTo) {
////
////            $this->innerJoin(Price::tableName(),
////                Roomtype::tableName().'.sanatorium_id = ' .Price::tableName().'.sanatorium_id AND ' .
////                Roomtype::tableName().'.manual_rooms_id = ' .Price::tableName().'.manual_room_id AND ' .
////                Roomtype::tableName().'.id = ' .Price::tableName().'.sanatorium_room_type_id'
////            );
////
////            if ($dateFrom) {
////                $this->andWhere(['<=', 'begin_date', $dateFrom]);
////                $this->andWhere(['>=', 'end_date', $dateFrom]);
////            }
////
////            if ($dateTo) {
////                $this->andWhere(['<=', 'begin_date', $dateTo]);
////                $this->andWhere(['>=', 'end_date', $dateTo]);
////            }
////        }
//
//        return $this;
//    }

//    /**
//     * Тип питания
//     * @return \thread\models\query\ActiveQuery
//     */
//
//    public function getFilterTypeFood($params)
//    {
//        if ($params) {
//            $this->innerJoinWith('relSanAreasTreatment')
//                ->andWhere(['fv_manual_areas_treatment.id' => $params])
//                ->andWhere('is_main = 1 OR is_secondary = 1');
//        }
//        return $this;
//    }


    /**
     * Фильтрация по id санатория
     */

    public function getFilterSanatoriumsId(Array $sanatoriums_id)
    {
        $this->andWhere([Sanatoriums::tableName() . '.id' => $sanatoriums_id]);
        return $this;
    }


    /**
     * Лечабная база (только 0й уровень)
     * @return \thread\models\query\ActiveQuery
     */

    public function getFilterMedBase(Array $params)
    {
        if ($params) {
            $this->innerJoinWith('relSanMedBase')->andWhere(['fv_manual_medical_base.group_id' => $params]);
        }
        return $this;
    }


    /**
     * @param null $city
     * @param $searchParams
     * @return $this
     */

    public function getFilterCity($city = null, $searchParams, $withSearchParams)
    {
        if ($city) {
            $this->andWhere(['location_city_id' => $city]);
        }

        $cityArray = $searchParams->getParamCityList();

//        /**/ echo '<pre style="color: red">'; print_r($cityArray); echo '</pre>'; die(); /**/

        if ($withSearchParams && $cityArray && current($cityArray)) {
            $this->andWhere(['IN', 'location_city_id', $searchParams->getParamCityList()]);
        }

        return $this;
    }


    /**
     * @param null $country_id
     * @param $searchParams
     * @return $this
     */

    public function getFilterCountry($country_id = null, $searchParams, $withSearchParams)
    {
        if ($country_id) {
            $this->andWhere(['location_country_id' => $country_id]);
        }

        if ($withSearchParams && $searchParams->getParamCountryList()) {
            $this->andWhere(['IN', 'location_country_id', $searchParams->getParamCountryList()]);
        }

        return $this;
    }


    /**
     * @param $searchParams
     * @return $this
     */

    public function getFilterSanatoriums($searchParams, $withSearchParams)
    {
        $sanArray = $searchParams->getParamSanatoriums();

//        /**/ echo '<pre style="color: red">'; print_r($searchParams->getParamSanatoriums()); echo '</pre>'; die(); /**/
        if ($withSearchParams && $sanArray && current($sanArray)) {
            $this->andWhere(['IN', Sanatoriums::tableName() . '.id', $searchParams->getParamSanatoriums()]);
        }

        return $this;
    }

    /**
     * @param $sortParams
     * @param $searchParams
     * @return $this
     */

    public function getSortSanatoriumList($sortParams, $searchParams)
    {
        if (SearchParams::SORT_QUALITY_TREATMENT === $sortParams) {
            $this->joinWith('totalComment')
                ->orderBy(TotalComment::tableName() . '.total_quality ASC');
//            $this->orderBy('rating DESC');

        } elseif (SearchParams::SORT_REVIEWS === $sortParams) {
            $this->joinWith('totalComment')
                ->orderBy(TotalComment::tableName() . '.average_rating DESC');

        }

        elseif(SearchParams::SORT_BEST === $sortParams){
            $this->orderBy('`page_index` IS NULL asc, `page_index` asc');
        }
        elseif (SearchParams::SORT_DISCOUNT === $sortParams && $searchParams->getParamDateTo() && $searchParams->getParamDateFrom())
        {
            $this->joinWith('discount')
                ->andWhere('begin_discount <= :from_date',[':from_date' => $searchParams->getParamDateFrom()])
                ->andWhere('end_discount >= :to_date',[':to_date' => $searchParams->getParamDateTo()])
                ->andWhere(Discount::tableName().'.deleted >= :deleted',[':deleted' => 1])
                ->orderBy(Discount::tableName() . '.discount DESC');
        }
        elseif (SearchParams::SORT_CHEAP === $sortParams && $searchParams->getParamDateTo() && $searchParams->getParamDateFrom()) {
            $clone = clone $this;
            $sanatoriums = $clone
                ->select(Sanatoriums::tableName() . '.id')
                ->indexBy(Sanatoriums::tableName() . '.id')
//                ->limit(Yii::$app->params['numberSanatoriums'])
                ->column();

            $sanatoriumsPrice = [];

            if ($sanatoriums) {
                foreach ($sanatoriums as $key => $sanatoriumId) {
                    $selection = new Selection($sanatoriumId);

                    $userPrice = Roomtype::getDiscountPriceForSecondRooms($selection->getSecondRoomsWithMinPrice(), $selection, 0);

                    if ($userPrice == 0) {
                        $userPrice = Roomtype::getPriceForSecondRooms($selection->getSecondRoomsWithMinPrice(), $selection, 0);
                    }

                    $sanatoriumsPrice[$sanatoriumId] = $userPrice;
                }


                if ($sanatoriumsPrice) {
                    asort($sanatoriumsPrice);
                    $sanPricesId = [];

                    foreach ($sanatoriumsPrice as $id => $price) {
                        $sanPricesId[] = $id;
                    }

                    $sanPricesIdList = implode(', ', $sanPricesId);
                    $this->orderBy([new \yii\db\Expression('FIELD (' . Sanatoriums::tableName() . '.id, ' . $sanPricesIdList . ')')]);
                }
            }
        }

        return $this;
    }
}
