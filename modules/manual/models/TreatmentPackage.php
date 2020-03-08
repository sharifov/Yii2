<?php

namespace thread\modules\manual\models;
use thread\modules\sanatorium\models\RelSanatoriumsTreatmentPackage;
use Yii;

class TreatmentPackage extends \thread\models\ActiveRecord
{
    /**
     * enum Type (кол-во дней)
     */
    const type = ['0' => '0', '1' => '1', '3' => '3', '7' => '7', '10' => '10'];
    const fileUploadFolder = 'upload/manual/treatmentpackage';



    const imgFood = 'images/icons/food.png';
    const imgNights = 'images/icons/nights.png';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_treatment_package}}';
    }

    public function rules()
    {
        return [
            [['published', 'deleted', 'recalculated'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['type'], 'in', 'range' => array_keys(self::type)],
            [['create_time', 'position', 'update_time'], 'integer'],
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
            'type' => Yii::t('app', 'days'),
            'value' => Yii::t('app', 'examinations'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'image_link' => Yii::t('app', 'image_link'),
            'recalculated' => Yii::t('app', 'recalculated'),
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
                'value',
                'published',
                'deleted',
                'image_link',
                'recalculated',
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
     * Проверка на использования Лечебного пакета у санатория
     * @return \yii\db\ActiveQuery
     */

    public function usedOfRelSanaorium($sanatorim_id)
    {
        return RelSanatoriumsTreatmentPackage::find_base()->andWhere([
            'sanatorium_id' => $sanatorim_id,
            'treatment_package_id' => $this->id
        ])->one();
    }

    /**
     *
     * @return string
     */

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

    public static function dropDownYesNo() {
        return  [ self::STATUS_KEY_OFF =>  Yii::t('app', 'KEY_NO'), self::STATUS_KEY_ON =>  Yii::t('app', 'KEY_YES')];
    }

    /**
     *
     * Проверяем с значением или без
     */
    public function withValue() {
        return ( ! (empty($this->recalculated))) ? true : false;
    }

    /**
     *
     * Получаем количество дней питания
     */

    public static function getNumberDaysFood($typeFood, $days) {
        $food = 3;

        if (strpos($typeFood, 'HB' ) !== false) {
            $food =  2;
        }

        return Yii::t('app', '{n}-x meals', ['n' => $food]);
    }
}
