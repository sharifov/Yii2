<?php

namespace thread\modules\review\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\modules\user\User;

/**
 * Class Review
 *
 * @package thread\modules\review\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Review extends \thread\models\ActiveRecord {

    public static $commonQuery = query\ReviewQuery::class;

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\review\Review::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%review}}';
    }

    /**
     * 
     * @return array
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
        ]);
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['item_id', 'title', 'description', 'user_id'], 'required'],
            [['create_time', 'update_time', 'item_id', 'user_id', 'ratingCount'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 2048],
            [['ratingValue'], 'double'],
            [['user_id', 'item_id'], 'unique', 'targetAttribute' => ['user_id', 'item_id']],
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
            'backend' => ['item_id', 'user_id', 'title', 'description', 'published', 'deleted'],
            'ratingupdate' => ['ratingCount', 'ratingValue'],
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'user_id' => Yii::t('app', 'user'),
            'item_id' => Yii::t('app', 'item'),
            'title' => Yii::t('app', 'title'),
            'description' => Yii::t('app', 'description'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'ratingValue' => Yii::t('app', 'ratingValue'),
            'ratingCount' => Yii::t('app', 'ratingCount'),
        ];
    }

    /**
     * 
     * @return ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
