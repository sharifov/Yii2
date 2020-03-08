<?php

namespace thread\modules\widgetsetting\models;
use thread\modules\location\models\City;
use thread\modules\location\models\Country;
use thread\modules\manual\models\Areastreatment;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class AreasTreatmentWidget extends \thread\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_areas_treatment}}';
    }

    public static function getDb()
    {
        return \thread\modules\company\CompanyModule::getDb();
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'areas_treatment_id',
                    'create_time',
                    'update_time',
                    'position',
                ],
                'integer'
            ],
            [[ 'image_link'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'areas_treatment_id' => Yii::t('app', 'Areas_treatment'),
            'image_link' => Yii::t('app', 'image_link'),
            'position' => Yii::t('app', 'position')
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
                'areas_treatment_id',
                'image_link',
                'position',
            ],
        ];
    }

    /**
     *
     * @return yii\db\ActiveQuery
     */
    public function getAreastreatment()
    {
        return $this->hasOne(Areastreatment::class, ['id' => 'areas_treatment_id']);
    }

    public function getImageLinkUrl() {
//        Заменить на Yii::$app->getModule('news')->getImageBaseUrl()

        return ($this->image_link) ? 'frontend/upload/widgetsetting/areasTreatment' . '/' . $this->image_link : '';
    }

}
