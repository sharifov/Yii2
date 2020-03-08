<?php

namespace thread\modules\faq\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

/**
 * Class Faq
 *
 * @package thread\modules\faq\models
 */
class Faq extends \thread\models\ActiveRecord
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
        return '{{%faq}}';
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['question', 'answer'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['question', 'answer'],
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
            [['question', 'lang'], 'required'],
            [['group_id', 'create_time', 'update_time','position'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(self::statusKeyRange())],
            [['question'], 'string', 'max' => 525],
//            [['answer'], 'string', 'max' => 4096],
            ['lang', 'string', 'min' => 5, 'max' => 5],
            [['id', 'lang'], 'unique', 'targetAttribute' => ['id', 'lang'], 'message' => 'The combination of rid and lang has already been taken.'],
            [['group_id', 'position'], 'default', 'value' => '0']
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
            'backend' => ['lang', 'group_id', 'question', 'answer', 'position', 'published', 'deleted']
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
            'group_id' => Yii::t('app', 'group_id'),
            'question' => Yii::t('faq', 'Question'),
            'answer' => Yii::t('faq', 'Answer'),
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
}
