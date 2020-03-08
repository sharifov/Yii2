<?php

namespace thread\modules\company\models;

use thread\modules\sanatorium\Sanatorium;
use Yii;
use yii\db\ActiveRecord;

/**
 * Class RelSanatoriumHoteloptions
 * 
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, VipDesign
 */
class RelTransferSanatorium extends ActiveRecord {

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
    public static function tableName() {
        return '{{%company_transfer_rel_sanatoriums}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['sanatorium_id', 'transfer_id'], 'required'],
            [['sanatorium_id', 'transfer_id'], 'integer'],
        ];
    }
    
    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'transfer_id' => Yii::t('app', 'transfer'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatorium::class, ['id' => 'sanatorium_id']);
    }
//
    /**
     * @return ActiveQuery
     */
    public function getHoteloptions()
    {
        return $this->hasOne(Transfer::class, ['id' => 'transfer_id']);
    }
}
