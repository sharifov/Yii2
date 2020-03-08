<?php

namespace thread\modules\location\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Currency
 *
 * @package thread\modules\location\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Currency extends \thread\models\ActiveRecord
{
    protected static $list = NULL;

    const DEFAULT_CURRENCY_SYMBOL = '&#8364;';
    const DEFAULT_CURRENCY_ID = 3;

    static $euroModel = null;


    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\location\Location::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%location_currency}}';
    }

    /**
     *
     * @return array
     */
    public function behaviors()
    {
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
    public function rules()
    {
        return [
            [['alias'], 'required'],
            [['create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['code1', 'code2'], 'string', 'max' => 4],
            [['alias'], 'string', 'max' => 255],
            [['currency_symbol'], 'string', 'max' => 100],
            [['course'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['alias'], 'unique']
        ];
    }

    /**
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'backend' => ['alias', 'code1', 'course', 'code2', 'published', 'currency_symbol', 'deleted'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'alias' => Yii::t('app', 'alias'),
            'code1' => Yii::t('app', 'code1'),
            'code2' => Yii::t('app', 'code2'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'course' => Yii::t('app', 'course'),
            'currency_symbol' => Yii::t('app', 'currency_symbol'),
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(CurrencyLang::class, ['rid' => 'id']);
    }

    static function getList()
    {
        if (self::$list === NULL) {

            $list_all = self::find()->published()->all();

            $l = array();
            foreach ($list_all as $data) {
                $l[$data->code2] = $data;
            }

            self::$list = $l;
        }
        return self::$list;
    }

    /**
     * The Base method for query construction of the method find
     * @return yii\db\ActiveQuery
     */
    public static function find_base() {
        return self::find()->enabled();
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownList() {
        return ArrayHelper::map(self::find_base()->all(), 'id', 'lang.title');
    }

    /**
     * Получить модель евро
     */
    public static function getEuroModel() {

        if (self::$euroModel === null) {
            self::$euroModel = self::findById(self::DEFAULT_CURRENCY_ID);
        }

        return self::$euroModel;
    }
}
