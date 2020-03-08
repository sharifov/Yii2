<?php

namespace thread\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class GroupLang
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class GroupLang extends \thread\models\ActiveRecordLang {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\user\User::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%user_group_lang}}';
    }


    /**
     * 
     * @return array
     */
    public function rules() {
        return ArrayHelper::merge(parent::rules(), [
                    [['title'], 'required'],
                    ['rid', 'exist', 'targetClass' => Group::className(), 'targetAttribute' => 'id'],
        ]);
    }


    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
        ];
    }

}
