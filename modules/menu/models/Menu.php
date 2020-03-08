<?php

namespace thread\modules\menu\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Menu
 *
 * @package thread\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Menu extends \thread\models\ActiveRecord {


    const IMPORTANT_LINKS_ID = 2;
    const OUR_PARTNERS_ID = 6;


    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\menu\Menu::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%menu}}';
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
            [['alias'], 'required'],
            [['create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'backend' => ['alias', 'published', 'deleted'],
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
            'readonly' => Yii::t('app', 'readonly'),
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(MenuLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getItems() {
        return $this->hasMany(Item::class, ['group_id' => 'id'])->undeleted();
    }



}
