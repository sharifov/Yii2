<?php

namespace thread\modules\user\models;

use Yii;
use thread\modules\company\models\Company;
use yii\helpers\ArrayHelper;

/**
 * Class Profile
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Profile extends \thread\models\ActiveRecord {

    /**
     * @var string
     */
    public static $commonQuery = query\ProfileQuery::class;

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
        return '{{%user_profile}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['user_id'], 'unique'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            [['user_id', 'create_time', 'update_time'], 'integer'],
            [['name', 'surname', 'image_link'], 'string', 'max' => 255],
            [['preferred_language'], 'string', 'min' => 5, 'max' => 5]
        ];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'backend' => ['name', 'surname', 'image_link', 'preferred_language'],
            'profile' => ['name', 'surname', 'image_link', 'preferred_language'],
            'frontend' => ['name', 'surname', 'image_link', 'preferred_language'],
            'ownedit' => ['name', 'surname', 'image_link', 'preferred_language'],
            'basiccreate' => ['user_id'],
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('user', 'name'),
            'surname' => Yii::t('user', 'surname'),
            'image_link' => Yii::t('app', 'image_link'),
            'preferred_language' => Yii::t('user', 'preferred_language'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     *
     * @param integer $user_id
     * @return ActiveRecord|null
     */
    public static function findByUserId($user_id) {
        return self::find()->user_id($user_id)->one();
    }

    /**
     * 
     * @return string
     */
    public function getFullName() {
        return $this->surname . ' ' . $this->name;
    }

}
