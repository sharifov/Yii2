<?php

namespace thread\modules\company\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

/**
 * Class CompanyLang
 *
 * @package thread\modules\company\models
 */
class TransfercompanyLang extends \thread\models\ActiveRecordLang
{
    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\company\CompanyModule::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%company_transfer_company_lang}}';
    }


    /**
     *
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Transfercompany::class, 'targetAttribute' => 'id'],
            ['content', 'string'],
            [['content', 'contact_person', 'address', 'postcode', 'representative'], 'default', 'value' => ''],
            [['title', 'contact_person', 'address', 'postcode', 'representative', 'tax_number', 'vat_number'], 'string', 'max' => 255],
        ]);
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('company', 'Company title'),
            'content' => Yii::t('app', 'content'),
            'contact_person' => Yii::t('company', 'Contact person'),
            'address' => Yii::t('company', 'Address'),
            'postcode' => Yii::t('company', 'Postcode'),
            'representative' => Yii::t('company', 'Representative'),
            'tax_number' => Yii::t('company', 'Tax number'),
            'vat_number' => Yii::t('company', 'VAT number'),
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'backend' => ['title', 'content', 'contact_person', 'address', 'postcode', 'representative', 'tax_number', 'vat_number'],
        ];
    }

}
