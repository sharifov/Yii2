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

class OutteamLang extends \thread\models\ActiveRecordLang {

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
        return '{{%manual_our_team_lang}}';
    }

    public function behaviors() {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return  [
            ['rid', 'exist', 'targetClass' => Outteam::class, 'targetAttribute' => 'id'],
            [['appointment', 'fio'], 'string', 'max' => 255],
            ['content', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'appointment' => Yii::t('manual', 'appointment'),
            'fio' => Yii::t('manual', 'fio'),
            'content' => Yii::t('app', 'info'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['content', 'fio', 'appointment'],
        ];
    }

}
