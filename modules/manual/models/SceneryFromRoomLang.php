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

class SceneryFromRoomLang extends \thread\models\ActiveRecordLang {

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
        return '{{%manual_scenery_from_room_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['title'], 'required'],
            ['rid', 'exist', 'targetClass' => SceneryFromRoom::class, 'targetAttribute' => 'id'],
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
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['title'],
        ];
    }

}
