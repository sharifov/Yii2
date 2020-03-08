<?php

namespace thread\modules\sanatorium\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class RelSanatoriumHoteloptions
 * 
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, VipDesign
 */
class RelSanatoriumAreasTreatment extends ActiveRecord {

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
        return '{{%sanatorium_rel_manual_areas_treatment}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['sanatorium_id', 'areas_treatment_id'], 'required'],
            [['sanatorium_id', 'areas_treatment_id', 'is_main', 'is_secondary'], 'integer'],
        ];
    }
    
    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'hoteloptions_id' => Yii::t('app', 'areas_treatment_id'),
            'is_main' => Yii::t('app', 'is_main'),
            'is_secondary' => Yii::t('app', 'is_secondary'),
        ];
    }

    public  static function findAreastment($sanatorium_id, $areasment_id) {
        return self::find()->andWhere(['sanatorium_id' => $sanatorium_id, 'areas_treatment_id' => $areasment_id])->one();
    }

//    /**
//     * @return ActiveQuery
//     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id'])->enabled();
    }

    public function getAreastreatment()
    {
        return $this->hasOne(\thread\modules\manual\models\Areastreatment::class, ['id' => 'areas_treatment_id'])->enabled();
    }
//
//    /**
//     * @return ActiveQuery
//     */
//    public function getHoteloptions()
//    {
//        return $this->hasOne(Hoteloptions::class, ['id' => 'hoteloptions_id']);
//    }
}
