<?php

namespace thread\modules\sanatorium\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fv_sanatorium_rooms_lang".
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $desc_short
 *
 * @property string anatoriumRooms
 */
class SanatoriumsLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\sanatorium\Sanatorium::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%sanatorium_sanatoriums_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Sanatoriums::class, 'targetAttribute' => 'id'],
            [['title', 'sanatorium_currency'], 'string', 'max' => 255],
            [['content', 'review', 'newyear','price_medical','documents_client','documents_child','expert_opinion', 'terms_of_payment', 'useful_to_know', 'resort_rate', 'agreement_text', 'sanatorium_currency'], 'string'],
            [['booking_payment_terms'], 'string', 'max' => 4096],
            [['content'],  'default', 'value' => ''],

        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'meta_desc' => Yii::t('app', 'meta_desc'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_h1' => Yii::t('app', 'meta_h1'),
            'content' => Yii::t('app', 'content'),
            'review' => Yii::t('sanatorium', 'review'),
            'newyear' => Yii::t('sanatorium', 'newyear'),
            'price_medical' => Yii::t('sanatorium', 'price_medical'),
            'documents_client' => Yii::t('sanatorium', 'documents_client'),
            'documents_child' => Yii::t('sanatorium', 'documents_child'),
            'expert_opinion' => Yii::t('sanatorium', 'expert_opinion'),
            'terms_of_payment' => Yii::t('sanatorium', 'terms_of_payment'),
            'advantages' => Yii::t('sanatorium', 'advantages'),
            'useful_to_know' => Yii::t('sanatorium', 'Useful to know'),
            'booking_payment_terms' => Yii::t('sanatorium', 'Booking terms of payment'),
            'resort_rate' => Yii::t('app', 'Resort rate'),
            'agreement_text' => Yii::t('app', 'Agreement Text'),
            'sanatorium_currency' => Yii::t('app', 'Sanatorium currency'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => [
                'title',
                'meta_title',
                'meta_desc',
                'meta_keywords',
                'meta_h1',
                'content',
                'advantages',
                'review',
                'newyear',
                'price_medical',
                'documents_client',
                'documents_child',
                'expert_opinion',
                'terms_of_payment',
                'useful_to_know',
                'booking_payment_terms',
                'resort_rate',
                'agreement_text',
                'sanatorium_currency',
            ],
        ];
    }

    public static function dropDownList()
    {
        return ArrayHelper::map(self::find()->where(['lang' => Yii::$app->language])->all(), 'rid', 'title');
    }
}
