<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;


class Consultant extends \thread\models\ActiveRecord
{

    const fileUploadFolder = 'upload/services/item';
    const IS_FORM = 'form-consultant';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_consultants}}';
    }

    public function rules()
    {
        return [
//            [['alias'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'position', 'update_time'], 'integer'],
            [['image_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'image_link' => Yii::t('app', 'image_link'),
            'position' => Yii::t('app', 'position')
        ];
    }


    /**
     *
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted'   => ['deleted'],
            'backend'   => ['image_link', 'position', 'create_time', 'update_time', 'published', 'deleted'],
        ];
    }

    public function getLang()
    {
        return $this->hasOne(ConsultantLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getGalleryBaseUrl()
    {
        return Yii::$app->request->hostInfo . '/' . self::fileUploadFolder;
    }

    /**
     *
     * @return string
     */
    public function getGalleryBasePath()
    {
        return Yii::getAlias('@root') . '/frontend/' . self::fileUploadFolder;
    }

    // Дописать проверку на наличие файла
    public function getImageLink() {

        if (file_exists($this->getGalleryBasePath(). '/' .$this->image_link)) {
            return $this->getGalleryBaseUrl(). '/' .$this->image_link;
        }
        return false;
    }




}
