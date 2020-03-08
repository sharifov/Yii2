<?php

namespace thread\modules\sanatorium\models;
use Yii;

class TreatmentPackage extends \thread\models\ActiveRecord
{
    /**
     * enum Type (кол-во дней)
     */
    const type = [0, 1, 3, 7, 10];
    const fileUploadFolder = 'upload/sanatorium/treatmentpackage';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sanatorium_treatment_package}}';
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => array_keys(self::type)],
            [['create_time', 'sanatorium_id', 'position', 'update_time'], 'integer'],
            [['image_link'], 'string','max' => 255],
            [['value'],  'double'],
            [['position', 'value'],  'default', 'value' => 0],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'position' => Yii::t('app', 'position'),
            'type' => Yii::t('app', 'type'),
            'value' => Yii::t('app', 'value'),
            'sanatorium_id' => Yii::t('app', 'sanatorium_id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'image_link' => Yii::t('app', 'image_link'),
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
            'backend' => [
                'position',
                'type',
                'sanatorium_id',
                'value',
                'published',
                'deleted',
                'image_link'
            ],
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */

    public function getLang()
    {
        return $this->hasOne(TreatmentPackageLang::class, ['rid' => 'id']);
    }

    /**
     *  Тип номера (Вид номеров)
     * @return \yii\db\ActiveQuery
     */
    public function getSanatorium()
    {
        return $this->hasOne(Sanatoriums::class, ['id' => 'sanatorium_id']);
    }

    public function getImageLink() {
        return  ($this->image_link) ? '/'. self::fileUploadFolder . '/' . $this->image_link : '';
    }

    /**
     *
     * @return string
     */
    public function getGalleryBasePath()
    {
        return Yii::getAlias('@root') . '/frontend/' . self::fileUploadFolder;
    }

    /**
     *
     * @return string
     */
    public function getGalleryBaseUrl()
    {
        return Yii::$app->request->hostInfo . '/' . self::fileUploadFolder;
    }
}
