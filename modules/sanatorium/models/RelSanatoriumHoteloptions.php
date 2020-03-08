<?php

namespace thread\modules\sanatorium\models;

use thread\modules\manual\models\Hoteloptions;
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
class RelSanatoriumHoteloptions extends ActiveRecord {

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
        return '{{%sanatorium_rel_hoteloptions}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['sanatorium_id', 'hoteloptions_id','additional_options'], 'required'],
            [['sanatorium_id', 'hoteloptions_id'], 'integer'],
        ];
    }
    
    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'hoteloptions_id' => Yii::t('app', 'hoteloptions_id'),
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatorium::class, ['id' => 'sanatorium_id']);
    }
    
    /**
     * @return ActiveQuery
     */
    public function getHoteloptions()
    {
        return $this->hasOne(Hoteloptions::class, ['id' => 'hoteloptions_id']);
    }
}
