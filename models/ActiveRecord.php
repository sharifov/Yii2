<?php

namespace thread\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * Class ActiveRecord
 * Base ActiveRecord [[ActiveRecord]]
 *
 * @package thread\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
abstract class ActiveRecord extends \yii\db\ActiveRecord
{

    const STATUS_KEY_ON = '1';
    const STATUS_KEY_OFF = '0';

    /**
     * @var string
     */
    public static $commonQuery = query\ActiveQuery::class;

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['update_time', 'create_time'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time'],
                ],
            ],
        ];
    }

    /**
     * @return yii\db\ActiveQuery
     */
    public static function find()
    {
        return new static::$commonQuery(get_called_class());
    }

    /**
     * The Base method for query construction of the method find
     * @return yii\db\ActiveQuery
     */
    public static function find_base()
    {
        return self::find();
    }

    /**
     *
     * @param string $id
     * @return ActiveRecord|null
     */
    public static function findById($id)
    {
        return self::find_base()->byID($id)->one();
    }

    /**
     *
     * @param string $alias
     * @return ActiveRecord|null
     */
    public static function findByAlias($alias)
    {
        return self::find_base()->alias($alias)->one();
    }

    /**
     * The status fields for key type
     * @return array
     */
    public static function statusKeyRange()
    {
        return [
            static::STATUS_KEY_ON => Yii::t('app', 'KEY_ON'),
            static::STATUS_KEY_OFF => Yii::t('app', 'KEY_OFF')
        ];
    }


    /**
     * The status fields for key type
     * @return array
     */
    public static function statusKeyYesNo()
    {
        return [
            static::STATUS_KEY_OFF => Yii::t('app', 'KEY_NO'),
            static::STATUS_KEY_ON => Yii::t('app', 'KEY_YES')
        ];
    }

    /**
     * Returns presence attribute in the model
     * @param string $attribute
     * @return boollean
     */
    public function is_attribute($attribute)
    {
        return (in_array($attribute, $this->attributes())) ? true : false;
    }

    /**
     * Returns presence scenario in the model
     * @param string $scenario
     * @return boollean
     */
    public function is_scenario($scenario)
    {
        return (array_key_exists($scenario, $this->scenarios())) ? true : false;
    }

    /**
     * Updates connectivity
     * @param array $keys
     * @param ActiveRecord $class
     * @param string $link
     */
    protected function relationRefresh($keys, $class, $link)
    {
        $item = $class::findAll($keys);

        foreach ($this->$link as $c)
            $this->unlink($link, $c, true);

        foreach ($item as $i)
            $this->link($link, $i);
    }

    /**
     * Get value from LangTable
     * @param string $attribute
     * @return string
     */

    public function getLangAttr($attribute)
    {
        return (isset($this->lang->$attribute)) ? $this->lang->$attribute : '';
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownList()
    {
        return ArrayHelper::merge(['0' => ''], ArrayHelper::map(self::find_base()->all(), 'id', 'lang.title'));
    }

    /**
     * Вынести в модель FRONTEND
     *
     * @return array
     */
    public static function dropDownListFrontend()
    {
        return ArrayHelper::merge(['0' => 'Выбрать'], ArrayHelper::map(self::find_base()->undeleted()->all(), 'id', 'lang.title'));
    }

}
