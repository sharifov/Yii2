<?php

namespace thread\modules\sanatorium\models;

use frontend\components\BasketBooking;
use Yii;

class Penalties extends \thread\models\ActiveRecord
{
    
    const MIN_DATE_RANGE_1 = 0;
    const MIN_DATE_RANGE_2 = 3;
    const MIN_DATE_RANGE_3 = 8;
    const MIN_DATE_RANGE_4 = 15;
    const MIN_DATE_RANGE_5 = 22;
    const MIN_DATE_RANGE_6 = 29;
    const MAX_DATE_RANGE_1 = 2;
    const MAX_DATE_RANGE_2 = 7;
    const MAX_DATE_RANGE_3 = 14;
    const MAX_DATE_RANGE_4 = 21;
    const MAX_DATE_RANGE_5 = 28;
    const MAX_DATE_RANGE_6 = 29;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_penalties}}';
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'create_time',
                    'sanatorium_id',
                    'update_time',
                    'range_1',
                    'range_2',
                    'range_3',
                    'range_4',
                    'range_5',
                    'range_6'
                ],
                'integer'
            ],
            [
                [
                    'range_1',
                    'range_2',
                    'range_3',
                    'range_4',
                    'range_5',
                    'range_6'
                ],

                'number',
                'max'=>100,
            ],
            [
                [
                    'range_1',
                    'range_2',
                    'range_3',
                    'range_4',
                    'range_5',
                    'range_6'
                ],
                'number',
                'max' => 100,
                'min' => 0,
            ],
            [
                [
                    'range_1',
                    'range_2',
                    'range_3',
                    'range_4',
                    'range_5',
                    'range_6'
                ],
                'default',
                'value' => 0,
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'range_1' => Yii::t('app', 'range_1'),
            'range_2' => Yii::t('app', 'range_2'),
            'range_3' => Yii::t('app', 'range_3'),
            'range_4' => Yii::t('app', 'range_4'),
            'range_5' => Yii::t('app', 'range_5'),
            'range_6' => Yii::t('app', 'range_6'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
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
                'range_1',
                'range_2',
                'range_3',
                'range_4',
                'range_5',
                'range_6',
                'sanatorium_id',
            ],
        ];
    }

    /**
     * @param $date
     * @param $price
     *
     * @return array
     */
    public function getPenaltiesFromDate($date, $price)
    {
        $currentDay = date('d.m.Y');
        $dateBooking = Yii::$app->formatter->asDate($date, 'dd.MM.Y');

        $penalties = [];
        for ( $i=5; $i>=0 ; $i--) {

            if ($this->getRanges()[$i] == 0) {
                $tillDate = Yii::$app->formatter->asDate(strtotime("{$date} -" . $this->getMinDateRange()[$i] . "days"),
                    'dd.MM.Y');
            } else {
                $tillDate = Yii::$app->formatter->asDate(strtotime("{$date} -" . $this->getMaxDateRange()[$i] . "days"), 'dd.MM.Y');
            }
            $tillDateMin = Yii::$app->formatter->asDate(strtotime("{$date} -" . $this->getMinDateRange()[$i] . "days"),
                'dd.MM.Y');
            $tillDateMax = Yii::$app->formatter->asDate(strtotime("{$date} -" . $this->getMaxDateRange()[$i] . "days"), 'dd.MM.Y');

            $currentDay_totime = strtotime($currentDay);
            $dateBooking_totime = strtotime($dateBooking);
            $tillDate_totime = strtotime($tillDate);
            $tillDateMin_totime = strtotime($tillDateMin);
            $tillDateMax_totime = strtotime($tillDateMax);

//            if ($currentDay <= $tillDate && $dateBooking > $tillDate) {
                if ($currentDay_totime <= $tillDateMin_totime && $dateBooking_totime > $tillDateMax_totime) {
                if ($this->getRanges()[$i] == 0) {
                    $penalties['free'] = $tillDateMin_totime;

                } else {

                    $charge = number_format($price * $this->getRanges()[$i] / 100, 0, '', ' ');
                    $penalties['penalty'][$this->getRanges()[$i]]['tillDateMin'] = $tillDateMin_totime;
                    $penalties['penalty'][$this->getRanges()[$i]]['tillDateMax'] = $tillDateMax_totime;
                    $penalties['penalty'][$this->getRanges()[$i]]['charge'] = $charge;
                }
            }

//            echo "<pre> for: ". $i ."<br>";
//            print_r( $penalties );
//            echo "</pre>";
//            echo "<hr>";

        }

        // if пусто то тогда берем максимальную штрафную санкцию

        if ( ! $penalties) {
            $charge = number_format($price * $this->getRanges()[0] / 100, 0, '', ' ');
            $penalties['penalty'][$this->getRanges()[0]]['tillDate'] = $currentDay;
            $penalties['penalty'][$this->getRanges()[0]]['charge'] = $charge;
        }


        return $penalties;
    }

    /**
     *
     * Получаем сумму штраф на выбраную дату
     * @param $date - дата начала заезда в санаторий
     * @param $price
     */

    public function getPenalty($date, $price) {

        $currentDay = date('d-m-Y');
        $numberDays = BasketBooking::getTotalNumbersNightsStatic($currentDay ,$date);

        $minDateRange = $this->getMinDateRangeStatic();
        $maxDateRange = $this->getMaxDateRangeStatic();

        $keyAttr = 5;

        for ( $i = 4; $i >= 0; $i-- ) {
            if ($minDateRange[$i] <= $numberDays &&  $numberDays <= $maxDateRange[$i] ) {
                $keyAttr = $i;
                break;
            }
        }

        return number_format($price * $this->getRanges()[$keyAttr] / 100, 0, '', ' ');
    }



    /**
     * @return array
     */
    public function getMinDateRange()
    {
        return [
            self::MIN_DATE_RANGE_1,
            self::MIN_DATE_RANGE_2,
            self::MIN_DATE_RANGE_3,
            self::MIN_DATE_RANGE_4,
            self::MIN_DATE_RANGE_5,
            self::MIN_DATE_RANGE_6,
        ];
    }

    /**
     * @return array
     */
    public function getMaxDateRange()
    {
        return [
            self::MAX_DATE_RANGE_1,
            self::MAX_DATE_RANGE_2,
            self::MAX_DATE_RANGE_3,
            self::MAX_DATE_RANGE_4,
            self::MAX_DATE_RANGE_5,
            self::MAX_DATE_RANGE_6,
        ];
    }


    /**
     * @return array
     */
    public static function getMinDateRangeStatic()
    {
        return [
            self::MIN_DATE_RANGE_1,
            self::MIN_DATE_RANGE_2,
            self::MIN_DATE_RANGE_3,
            self::MIN_DATE_RANGE_4,
            self::MIN_DATE_RANGE_5,
            self::MIN_DATE_RANGE_6,
        ];
    }

    /**
     * @return array
     */
    public static function getMaxDateRangeStatic()
    {
        return [
            self::MAX_DATE_RANGE_1,
            self::MAX_DATE_RANGE_2,
            self::MAX_DATE_RANGE_3,
            self::MAX_DATE_RANGE_4,
            self::MAX_DATE_RANGE_5,
            self::MAX_DATE_RANGE_6,
        ];
    }

    /**
     * @return array
     */
    public function getRanges()
    {
        return [
            $this->range_1,
            $this->range_2,
            $this->range_3,
            $this->range_4,
            $this->range_5,
            $this->range_6,
        ];
    }

    /**
     * @return array
     */
    public static function getRangesDays()
    {
        return [
           self::MIN_DATE_RANGE_1 => self::MAX_DATE_RANGE_1,
           self::MIN_DATE_RANGE_2 => self::MAX_DATE_RANGE_2,
           self::MIN_DATE_RANGE_3 => self::MAX_DATE_RANGE_3,
           self::MIN_DATE_RANGE_4 => self::MAX_DATE_RANGE_4,
           self::MIN_DATE_RANGE_5 => self::MAX_DATE_RANGE_5,
        ];
    }

//
//    /**
//     * @return array
//     */
//    public static function getRangesAtribute()
//    {
//        return [
//            range_1,
//            range_2,
//            range_3,
//            range_4,
//            range_5,
//            range_6,
//        ];
//    }





}
