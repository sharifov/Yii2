<?php

namespace thread\modules\sanatorium\models;

use thread\modules\sanatorium\Sanatorium;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class RelSanatoriumHoteloptions
 * 
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, VipDesign
 */
class RelSanatoriumMedicalOffice extends ActiveRecord {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\sanatorium\Sanatorium::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%sanatorium_rel_manual_medical_office}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['sanatorium_id', 'medical_office_id'], 'required'],
            [['sanatorium_id', 'medical_office_id'], 'integer'],
            [['number_people'], 'integer', 'min' => 0],
        ];
    }
    
    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'medical_office_id' => Yii::t('app', 'medical_office_id'),
            'number_people' => Yii::t('app', 'number_people'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatorium::class, ['id' => 'sanatorium_id']);
    }
    
}
