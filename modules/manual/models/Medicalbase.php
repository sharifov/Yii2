<?php

namespace thread\modules\manual\models;

use thread\modules\sanatorium\models\RelSanatoriumsMedicalBase;
use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;
use yii\helpers\VarDumper;

class Medicalbase extends \thread\models\ActiveRecord
{
    const fileUploadFolder = 'upload/sanatoriums/relsanatoriumsrelmedicalbase';

    public $relMedicalBase = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_medical_base}}';
    }

    public function beforeSave($event)
    {

        if (parent::beforeSave($event)) {

            // Всех детей присваиваем новому родителю (не даем сделать вложеность  больше 2х)
            if ($this->getOldAttribute('group_id') == 0 && ($this->group_id != $this->getOldAttribute('group_id'))) {
                $childrens = self::find()->where('group_id = :group_id', [':group_id' => $this->id])->all();

                if ($childrens) {
                    foreach ($childrens as $children) {
                        $children->group_id = $this->group_id;
                        $children->save(false);
                    }
                }
            }

            return true;
        }
        return false;

    }


    public function behaviors()
    {
        return parent::behaviors();
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'group_id', 'position', 'update_time'], 'integer'],
            [['group_id'], 'default', 'value' => 0],
            [['image_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'id'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'group_id' => Yii::t('app', 'group_id'),
            'position' => Yii::t('app', 'position'),
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
            'backend' => ['group_id', 'position', 'image_link', 'create_time', 'update_time', 'published', 'deleted'],
        ];
    }

    /**
     * Возвращает список первого уровня
     * ($marge) = false возвращает список без мержа нулевого элеметна заголовка
     * @return array
     */

    public static function dropDownListTitle($id = null, $marge = true)
    {
        $rootList = self::find_base()->andWhere('group_id = 0')->enabled()->joinWith('lang')->orderBy('title');

        if ($id) {
            $rootList = $rootList->andWhere('id != :id', [':id' => $id]);
        }

        $rootList = $rootList->all();

        if ($marge) {
            $rootList = ArrayHelper::merge(['0' => 'Заголовок'], ArrayHelper::map($rootList, 'id', 'lang.title'));
        } else {
            $rootList = ArrayHelper::map($rootList, 'id', 'lang.title');
        }

        return $rootList;
    }


    /**
     * Список Подгруппы
     * @return array
     */
    public static function dropDownListSecondLevel($group_id)
    {
        return ArrayHelper::map(
            self::find()->andWhere('group_id = :group_id',
                [':group_id' => $group_id])->enabled()->joinWith('lang')->orderBy('title')->all(),
            'id',
            'lang.title'
        );
    }

    public function getLang()
    {
        return $this->hasOne(MedicalbaseLang::class, ['rid' => 'id']);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(Medicalbase::class, ['group_id' => 'id'])->undeleted();
    }

    /**
     * @return mixed
     */
    public function getParantItem()
    {
        return $this->hasOne(self::class, ['id' => 'group_id'])->undeleted();
    }

    /**
     * @return mixed
     */
    public function getParentModel($group_id = null)
    {
        return self::find_base()->byId($group_id)->one();
    }

    public function usedOfRelSanaorium($sanatorim_id)
    {
        return RelSanatoriumsMedicalBase::find_base()->andWhere([
            'sanatorium_id' => $sanatorim_id,
            'medical_base_id' => $this->id
        ])->one();
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
            $thumb = $this->getImageBasePath() . '/thumbs/thumb-222x148.' . $this->image_link;
            if (file_exists($thumb)) {
                return $this->getImageBaseUrl() . '/thumbs/thumb-222x148.' . $this->image_link;
            } else {
                return $this->getImageBaseUrl() . '/' . $this->image_link;
            }
        } else {
            return '';
        }
    }

    public function getFullImageLinkUrl()
    {
        if ($this->image_link && file_exists($this->getImageBasePath() . '/' . $this->image_link)) {
            return $this->getImageBaseUrl() . '/' . $this->image_link;
        } else {
            return '';
        }
    }
//
//    /**
//    +     * @param $sanatoriumId
//    +     * @return mixed
//    +     */
//
    public function getRelMedicalBase($sanatoriumId) {

        if ($sanatoriumId && $this->relMedicalBase === null) {
                $this->relMedicalBase = $this->usedOfRelSanaorium($sanatoriumId);
        }

        return $this->relMedicalBase;

    }
}
