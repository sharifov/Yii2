<?php

namespace thread\models;

use Yii;
use thread\behaviors\PurifierBehavior;

/**
 * Class ActiveRecordLang
 * Base ActiveRecord for language part [[ActiveRecordLang]]
 *
 * @package thread\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
abstract class ActiveRecordLang extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['rid', 'lang'];
    }

    /**
     *
     * @return array
     */
    public function behaviors() {

        return [
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'textAttributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
                ],
                'purifierOptions' => [
                    'HTML.AllowedElements' => Yii::$app->params['allowHtmlTags']
                ]
            ],
        ];
    }

    /**
     *
     * @return array
     */
    public function rules() {
        return [
            [['rid', 'lang'], 'required'],
            ['rid', 'integer'],
//            ['rid', 'exist', 'targetClass' => ActiveRecord::class, 'targetAttribute' => 'id'],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['rid', 'lang'], 'unique', 'targetAttribute' => ['rid', 'lang'], 'message' => 'The combination of rid and lang has already been taken.']
        ];
    }

    /**
     * Перевизначення базового find() для додавання default scopes
     * @return yii\db\ActiveQuery
     */
    public static function find() {
        return parent::find()->onCondition([static::tableName() . '.lang' => Yii::$app->language]);
    }

    /**
     *
     * @return array
     */
    public function scenarios() {
        return [
            'backend' => ['title'],
        ];
    }

    /**
     * Повертає наявність атрибута в моделі
     * @param string $attribute
     * @return boollean
     */
    public function is_attribute($attribute) {
        return (in_array($attribute, $this->attributes())) ? true : false;
    }

    /**
     * Повертає наявність сценарія в моделі
     * @param string $scenario
     * @return boollean
     */
    public function is_scenario($scenario) {
        return (array_key_exists($scenario, $this->scenarios())) ? true : false;
    }

}
