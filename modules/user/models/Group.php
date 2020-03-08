<?php

namespace thread\modules\user\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Group
 *
 * @package thread\modules\user\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Group extends \thread\models\ActiveRecord {

    const ADMIN = '1';
    const USER = '2';
    const ADMIN_COMPANY = '3';
    const ADMIN_SANATORIUM = '4';
    const WORKER_SANATORIUM = '5';

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
        return '{{%user_group}}';
    }


    /**
     * 
     * @return array
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'transliterate' => [
                        'class' => TransliterateBehavior::class,
                        'attributes' => [
                            \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['alias' => 'alias'],
                            \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['alias' => 'alias']
                        ]
                    ],
        ]);
    }


    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['alias', 'role'], 'required'],
            [['create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['role'], 'string', 'max' => 45],
            [['role'], 'default', 'value' => 'guest'],
        ];
    }


    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['alias', 'role', 'published', 'deleted'],
        ];
    }


    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'role' => Yii::t('app', 'role'),
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(GroupLang::class, ['rid' => 'id']);
    }

}
