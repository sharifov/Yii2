<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class CountryLang
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

class FacilitiesroomsLang extends \thread\models\ActiveRecordLang {


    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\manual\Manual::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%manual_facilities_rooms_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => Areastreatment::class, 'targetAttribute' => 'id'],
            [['info'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 255],
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
            'info' => Yii::t('app', 'info'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['title', 'info'],
        ];
    }

}
