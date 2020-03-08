<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class Hoteloptions
 *
 * @package thread\modules\manual\models
 */
class Hoteloptions extends \thread\models\ActiveRecord
{

    const fileUploadFolder = 'upload/sanatoriums/hoteloptions';
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
        return '{{%manual_hotel_options}}';
    }

    /**
     *
     * @return array
     */
    public function behaviors()
    {
        return parent::behaviors();
    }

    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['group_id', 'create_time', 'update_time'], 'integer'],
            [['image_link'], 'string', 'max' => 255],
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
            'backend' => ['group_id', 'published', 'deleted', 'image_link'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'image_link' => Yii::t('app', 'image_link'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(HoteloptionsLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(Hoteloptions::class, ['group_id' => 'id'])->undeleted();
    }

    /**
     *
     * @return array [id=>title]
     */
    public static function dropDownList($group_id = 0)
    {
        return ArrayHelper::map(self::find_base()->undeleted()->group_id($group_id)->all(), 'id', 'lang.title');
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
     *
     * @return string
     */
    public function getImageLinkUrl()
    {
        if ($this->image_link) {
            $path = $this->getImageBasePath() . '/' . $this->image_link;
            if (file_exists($path)) {
                return $this->getImageBaseUrl() . '/' . $this->image_link;
            }
        } else {
            return '';
        }
    }
    
    public static function getStaticImageUrl($imageName)
    {
        if ($imageName) {
            $path = Yii::getAlias('@root') . '/frontend/' . static::fileUploadFolder . '/' . $imageName;
            if (file_exists($path)) {
                return Yii::$app->request->hostInfo . '/' . static::fileUploadFolder . '/' . $imageName;
            }
        } else {
            return '';
        }
    }
}
