<?php

namespace thread\modules\company\models;

use thread\modules\sanatorium\models\Sanatoriums;
use Yii;

class Transfer extends \thread\models\ActiveRecord
{
    const TYPE_GROUP = 'group';
    const TYPE_PERSONAL = 'personal';

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_transfer}}';
    }

    public static function getDb()
    {
        return \thread\modules\company\CompanyModule::getDb();
    }

    public function rules()
    {
        return [
            [['alias', 'transfer_company_id', 'price', 'pass_number_min', 'pass_number_max'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'transfer_company_id',
                    'distance',
                    'create_time',
                    'update_time',
                    'start_transfer',
                    'end_transfer',
                    'pass_number_min',
                    'pass_number_max'
                ],
                'integer'
            ],
            [['price'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['type'], 'in', 'range' => array_keys(static::typeKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['sanatorium_ids'], 'safe'],
        ];
    }

    /**
     * The type fields for key type
     * @return array
     */
    public static function typeKeyRange()
    {
        return [
            'group' => Yii::t('app', 'group transfer type'),
            'personal' => Yii::t('app', 'personal type transfer'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'price' => Yii::t('company', 'price'),
            'type' => Yii::t('company', 'type_transfer'),
            'transfer_company_id' => Yii::t('app', 'transfer_company_id'),
            'distance' => Yii::t('company', 'distance'),
            'end_transfer' => Yii::t('company', 'end_transfer'),
            'start_transfer' => Yii::t('company', 'start_transfer'),
            'pass_number_min' => Yii::t('app', 'Min number of passengers'),
            'pass_number_max' => Yii::t('app', 'Max number of passengers'),
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
                'price',
                'type',
                'transfer_company_id',
                'create_time',
                'update_time',
                'published',
                'deleted',
                'distance',
                'end_transfer',
                'start_transfer',
                'sanatorium_ids',
                'pass_number_min',
                'pass_number_max'
            ],
        ];
    }

    /**
     *
     * @return type
     */
    public function getType()
    {
        $type = self::typeKeyRange();

        return $type[$this->type];
    }

    /**
     *
     * @return type
     */
    public function getLang()
    {
        return $this->hasOne(TransferLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return array|null
     */
    public function getTransferCompany()
    {
        return $this->hasOne(Transfercompany::class, ['id' => 'transfer_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStartTransferPoint()
    {
        return $this->hasOne(Transferpoints::class, ['id' => 'start_transfer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndTransferPoint()
    {
        return $this->hasOne(Transferpoints::class, ['id' => 'end_transfer']);
    }

    /**
     * Санатории
     * @return \yii\db\ActiveQuery
     */
    public function getRelTransferSan()
    {
        return $this->hasMany(Sanatoriums::class, ['id' => 'sanatorium_id'])
            ->viaTable('{{%company_transfer_rel_sanatoriums}}', ['transfer_id' => 'id']);
    }

    /**
     * Получиаем тип трасфера
     * @return string
     */
    public function getViewTypeTransferString() {

        if ($this->type === self::TYPE_GROUP){
            return Yii::t('front', 'group transfer type');
        }

        return Yii::t('front', 'personal type transfer');

    }

}
