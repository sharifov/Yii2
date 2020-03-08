<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Areastreatment
 *
 * @property mixed image_link
 * @package thread\modules\manual\models
 *
 */
class Areastreatment extends \thread\models\ActiveRecord
{

    const fileUploadFolder = 'upload/manual/areastreatment';

    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\manual\Manual::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%manual_areas_treatment}}';
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
            [['group_id', 'position', 'create_time', 'update_time'], 'integer'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['alias', 'image_link'], 'string', 'max' => 255],
            [['group_id', 'position'], 'default', 'value' => 0],
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
            'backend' => ['group_id', 'position', 'alias', 'image_link', 'published', 'deleted'],
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
            'group_id' => Yii::t('app', 'group'),
            'alias' => Yii::t('app', 'alias'),
            'position' => Yii::t('app', 'position'),
            'image_link' => Yii::t('app', 'image_link'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }

    public static function find_base()
    {
        return parent::find_base()->joinWith(['lang']);
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(AreastreatmentLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(Areastreatment::class, ['group_id' => 'id'])->undeleted();
    }

    /**
     * @return mixed
     */
    public function getParentModel($group_id = null)
    {
        return self::find_base()->byId($group_id)->one();
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownList($group_id = 0)
    {
        return ArrayHelper::map(self::find_base()->undeleted()->orderBy('position DESC')->group_id($group_id)->all(), 'id', 'lang.title');
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownListFrontend()
    {
        return ArrayHelper::merge(['' => Yii::t('front', 'Treatment direction')], ArrayHelper::map(self::find_base()->enabled()->group_id(0)->all(), 'id', 'lang.title'));
    }

    /**
     *
     * @return string
     */
    public function getImageBasePath()
    {
        return Yii::getAlias('@root') . '/frontend/' . self::fileUploadFolder;
    }

    /**
     *
     * @return string
     */
    public function getImageBaseUrl()
    {
        return Yii::$app->request->hostInfo . '/' . self::fileUploadFolder;
    }

    /**
     * @return string
     */
    public function getImageLink()
    {
        return $this->getImageBaseUrl() .'/' . $this->image_link;
    }
}
