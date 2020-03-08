<?php

namespace thread\modules\sanatorium\models;

use Yii;

class TotalComment extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_total_comments}}';
    }

    public function rules()
    {
        return [
            [
                [
                    'sanatorium_id',
                    'total_quality',
                    'total_quality_accommodation',
                    'total_quality_food',
                    'total_quality_staff',
                    'total_location',
                    'average_rating',
                    'total_comments',
                    'total_professionalism_doctor',
                ],
                'required'
            ],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'total_quality',
                    'total_quality_accommodation',
                    'total_quality_food',
                    'total_quality_staff',
                    'total_location',
                    'average_rating',
                    'total_comments',
                    'total_professionalism_doctor',
                ],
                'double'
            ],
            [['sanatorium_id'], 'integer'],
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
            'total_quality' => Yii::t('app', 'total_quality'),
            'total_quality_accommodation' => Yii::t('app', 'total_quality_accommodation'),
            'total_quality_food' => Yii::t('app', 'total_quality_food'),
            'total_quality_staff' => Yii::t('app', 'total_quality_staff'),
            'total_location' => Yii::t('app', 'total_location'),
            'average_rating' => Yii::t('app', 'average_rating'),

            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'total_professionalism_doctor' => Yii::t('app', 'total_professionalism_doctor'),
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
                'sanatorium_id',
                'total_quality',
                'total_quality_accommodation',
                'total_quality_food',
                'total_quality_staff',
                'total_location',
                'average_rating',
                'total_professionalism_doctor',

                'published',
            ],
        ];
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
     *   Добавление комментария
     * @return \yii\db\ActiveQuery
     */
    public function addComments(Comment $comment)
    {

        if ($this->total_comments > 0) {

            if ($comment->published==0 || $comment->published==1) {

//            типо того (((оценка в бд * кол-комменатиев в бд) + новый комментаний) / кол-комменатиев в бд +1 )
                $this->total_quality = ((($this->total_quality * $this->total_comments) + $comment->quality) / ($this->total_comments + 1));
                $this->total_quality_accommodation = ((($this->total_quality_accommodation * $this->total_comments) + $comment->quality_accommodation) / ($this->total_comments + 1));
                $this->total_quality_food = ((($this->total_quality_food * $this->total_comments) + $comment->quality_food) / ($this->total_comments + 1));
                $this->total_quality_staff = ((($this->total_quality_staff * $this->total_comments) + $comment->quality_staff) / ($this->total_comments + 1));
                $this->total_location = ((($this->total_location * $this->total_comments) + $comment->location) / ($this->total_comments + 1));
               // $this->total_professionalism_doctor = ((($this->total_professionalism_doctor * $this->total_comments) + $comment->professionalism_doctor) / ($this->total_comments + 1));

                // Не менять местами!!
                $this->total_comments++;
            }

        } else {

            $this->sanatorium_id = $comment->sanatorium_id;
            $this->total_quality = $comment->quality;
            $this->total_quality_accommodation = $comment->quality_accommodation;
            $this->total_quality_food = $comment->quality_food;
            $this->total_quality_staff = $comment->quality_staff;
            $this->total_location = $comment->location;
           // $this->total_professionalism_doctor = $comment->professionalism_doctor;

            $this->total_comments = 1;
        }

        $this->average_rating =
            (
                (
                    $this->total_quality +
                    $this->total_quality_accommodation +
                    $this->total_quality_food +
                    $this->total_quality_staff +
                    $this->total_location 
                   // $this->total_professionalism_doctor
                )
                / 5);

        $this->published = '1';

        $this->setScenario('backend');
        return $this->save();
    }

    /**
     *   Удаление комментария
     * @return \yii\db\ActiveQuery
     */

    public function delComments(Comment $comment)
    {

//        echo "<pre>";
//        print_r($comment);
//        echo "</pre>";
//        exit;

        if ($this->total_comments > 1) {

            if ($comment->published==1 && $comment->deleted==0) {
//          типо того (((оценка в бд * кол-комменатиев в бд) -  комментаний) * кол-комменатиев в бд -1 )
                $this->total_quality = ((($this->total_quality * $this->total_comments) - $comment->quality) / ($this->total_comments - 1));
                $this->total_quality_accommodation = ((($this->total_quality_accommodation * $this->total_comments) - $comment->quality_accommodation) / ($this->total_comments - 1));
                $this->total_quality_food = ((($this->total_quality_food * $this->total_comments) - $comment->quality_food) / ($this->total_comments - 1));
                $this->total_quality_staff = ((($this->total_quality_staff * $this->total_comments) - $comment->quality_staff) / ($this->total_comments - 1));
                $this->total_location = ((($this->total_location * $this->total_comments) - $comment->location) / ($this->total_comments - 1));
              //  $this->total_professionalism_doctor = ((($this->total_professionalism_doctor * $this->total_comments) - $comment->professionalism_doctor) / ($this->total_comments - 1));


                // Не менять местами!!
                $this->total_comments--;


            $this->average_rating =
                (
                    (
                        $this->total_quality +
                        $this->total_quality_accommodation +
                        $this->total_quality_food +
                        $this->total_quality_staff +
                        $this->total_location 
                     //   $this->total_professionalism_doctor
                    )
                    / 5);
            }
        } else {

            // т.к нету комментариев
            return $this->delete();
        }

        $this->setScenario('backend');
        return $this->save();
    }

    /**
     *   Получить процент
     * @return float (n.0)
     */

    public function getPercent($attribute)
    {
        return round((isset($this->$attribute)) ? $this->$attribute * 10 : 0, 1);
    }

    /**
     *   Получить округленный атрибут
     * @return float (n.0)
     */

    public function getRound($attribute)
    {
        $number = round((isset($this->$attribute)) ? $this->$attribute : 0, 1);

        return ($number > 10) ? 10 : $number;
    }


}
