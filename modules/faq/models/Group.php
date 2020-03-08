<?php

namespace thread\modules\faq\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

/**
 * Class Group
 *
 * @package thread\modules\faq\models
 */
class Group extends \thread\models\ActiveRecord
{

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\faq\Faq::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%faq_group}}';
    }

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'purifierBehavior' => [
                'class' => PurifierBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['title'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['title'],
                ],
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
            [['title', 'lang'], 'required'],
            [['create_time', 'update_time', 'position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['title'], 'string', 'max' => 255],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['id', 'lang'], 'unique', 'targetAttribute' => ['id', 'lang'], 'message' => 'The combination of rid and lang has already been taken.'],
            [['position'], 'default', 'value' => '0']
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
            'order' => ['position'],
            'backend' => ['lang', 'title', 'position', 'published', 'deleted']
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
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'position' => Yii::t('app', 'position'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted')
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {

        $this->lang = Yii::$app->language;

        return parent::beforeValidate();
    }

    /**
     * Перевизначення базового find() для додавання default scopes
     * @return yii\db\ActiveQuery
     */
    public static function find()
    {
        return parent::find()->onCondition([static::tableName() . '.lang' => Yii::$app->language]);
    }

    /**
     * @return mixed
     */
    public static function find_base()
    {
        return self::find()->undeleted()->innerJoinWith(["items"])->enabled()->orderBy(['position' => SORT_ASC]);
    }

    public static function dropDownList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'lang.title');
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(Faq::class, ['group_id' => 'id'])->undeleted()->orderBy(['position' => SORT_ASC]);
    }

}
