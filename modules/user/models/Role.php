<?php

namespace thread\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Role
 * 
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Role extends \thread\models\ActiveRecord {

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
        return '{{%auth_item}}';
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'name'),
            'data' => Yii::t('app', 'data'),
            'created_at' => Yii::t('app', 'create_time'),
            'updated_at' => Yii::t('app', 'update_time')
        ];
    }

    /**
     *
     * @return ActiveQuery|null
     */
    public static function all() {
        return static::find()->all();
    }

    /**
     *
     * @return array [name=>name]
     */
    public static function dropDownList() {
        return ArrayHelper::merge(['guest' => 'guest'], ArrayHelper::map(self::all(), 'name', 'name'));
    }

}
