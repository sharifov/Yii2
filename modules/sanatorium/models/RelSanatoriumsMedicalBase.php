<?php

namespace thread\modules\sanatorium\models;

use thread\modules\manual\models\Medicalbase;
use vova07\fileapi\behaviors\UploadBehavior;
use Yii;

/**
 * This is the model class for table "fv_sanatorium_rooms_lang".
 *
 * @property integer $rid
 * @property string $lang
 * @property string $title
 * @property string $desc_short
 *
 * @property string anatoriumRooms
 */
class RelSanatoriumsMedicalBase extends \thread\models\ActiveRecord
{
    private $published;

    const fileUploadFolder = 'upload/sanatoriums/relsanatoriumsrelmedicalbase';

    public function behaviors()
    {
        return  [
            'uploadBehavior' => [
                'class' => UploadBehavior::class,
                'attributes' => [
                    'image_link' => [
                        'path' => $this->getImageBasePath(),
                        'tempPath' => Yii::getAlias('@root') . '/temp',
                        'url' => $this->getImageBaseUrl()
                    ]
                ]
            ]
        ];
    }


    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\sanatorium\Sanatorium::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%sanatoriums_rel_manual_medical_base}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sanatorium_id', 'medical_base_id'], 'integer'],
            [['title', 'image_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'medical_base_id' => Yii::t('app', 'medical_base_id'),
            'image_link' => Yii::t('app', 'image_link'),
            'published' => Yii::t('app', 'published'),
        ];
    }

    public function scenarios()
    {
        return [
            'backend' => ['sanatorium_id', 'published', 'image_link', 'medical_base_id'],
        ];
    }


    /**
     * Санаторий
     * @return \yii\db\ActiveQuery || null
     */

    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    /**
     * Санаторий
     * @return \yii\db\ActiveQuery || null
     */

    public function getMedicalBase()
    {
        return $this->hasOne(Medicalbase::class, ['id' => 'medical_base_id']);
    }

    /**
     * Импровизация проверки модели
     * @return \yii\db\ActiveQuery || null
     */

    public  function getPublished() {
        return $this->published = ($this->isNewRecord) ? 0 : 1;
    }

    public  function setPublished($value) {
        return $this->published = $value;
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
        return ($this->image_link && (is_file($this->getImageBasePath(). '/' .$this->image_link )))
            ? $this->getImageBaseUrl() . '/' . $this->image_link
            : '';
    }






}
