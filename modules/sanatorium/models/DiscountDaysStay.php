<?php

namespace thread\modules\sanatorium\models;
use Yii;

class DiscountDaysStay extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */ 
    public static function tableName()
    {
        return '{{%sanatorium_discount_days_stay}}';
    }

    public function rules()
    {
        return [
            [['start_day', 'finish_day'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'update_time', 'start_day', 'finish_day', 'sanatorium_id', 'humans'], 'integer'],
            [['begin_date', 'end_date'], 'string'],
            [['discount'], 'double'],
            [['discount'], 'default', 'value' => 0],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'update_time' => Yii::t('app', 'update_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'start_day' => Yii::t('app', 'from the day'),
            'finish_day' => Yii::t('app', 'until the day'),
            'discount' => Yii::t('app', 'discount'),
            'begin_date' => Yii::t('app', 'begin_discount'),
            'end_date' => Yii::t('app', 'end_discount'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'humans' => Yii::t('app', 'humans'),
            'room_type' => Yii::t('app', 'room_type'),
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
                'start_day',
                'finish_day',
                'discount',
                'sanatorium_id',
                'humans',
                'begin_date',
                'end_date',
                'room_type',
                'published'
            ],
        ];
    }


    /**
     *  Санаторий
     * @return \yii\db\ActiveQuery
     */
    public function getRoomType()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    /**
     *  Валидация промежутков дат
     * @return \yii\db\ActiveQuery
     */

    public function dataValidation($attribute) {

        if ($attribute == 'start_day' || $attribute == 'finish_day') {

            $checkBeginDate = self::find_base()
                ->andWhere(['<=', 'start_day', $this->$attribute])
                ->andWhere(['>', 'finish_day', $this->$attribute])
                ->andWhere(['=', 'sanatorium_id', $this->sanatorium_id])
                ->undeleted();

            if ( ! $this->isNewRecord) {
                $checkBeginDate = $checkBeginDate->andWhere(['!=', 'id', $this->id]);
            }

            $checkBeginDate = $checkBeginDate->one();

            if ($checkBeginDate) {
                $this->addError($attribute, Yii::t('app', 'Date overlaps'));
            }

        }
    }

    public function beforeSave($insert) {

        //$this->dataValidation('start_day');
        //$this->dataValidation('finish_day');

        if ($this->begin_date &&  $this->end_date){
            if ($this->begin_date >=  $this->end_date) {
                $this->addError('end_date', Yii::t('app', 'The start date is greater than or equal to the end date'));
            }else{
                if (!is_integer($this->begin_date)) {
                    $this->begin_date = strtotime($this->begin_date);
                }
                if (!is_integer($this->end_date)) {
                    $this->end_date = strtotime($this->end_date);
                }
            }
        }


        if ($this->start_day >=  $this->finish_day) {
            $this->addError('finish_day', Yii::t('app', 'The start day is greater or equal to the end day'));
        }

        if ($this->getErrors()) {
            return false;
        }

        return parent::beforeSave($insert);
    }

}
