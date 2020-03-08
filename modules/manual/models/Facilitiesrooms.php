<?php

namespace thread\modules\manual\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;

/**
 * Class Article
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Facilitiesrooms extends \thread\models\ActiveRecord {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\manual\Manual::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%manual_facilities_rooms}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return [
            [['group_id', 'create_time', 'update_time', 'filter'], 'integer'],
            [['published', 'deleted', 'filter'], 'in', 'range' => array_keys(static::statusKeyRange())],
        ];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted' => ['deleted'],
            'filter' => ['filter'],
            'backend' => ['group_id', 'published', 'deleted', 'published_time', 'filter'],
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'group_id' => Yii::t('app', 'group'),
            'image_link' => Yii::t('app', 'image_link'),
            'published_time' => Yii::t('app', 'published_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'filter' => Yii::t('app', 'filter'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(FacilitiesroomsLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getPublishedTime() {
        $format = Yii::$app->modules['news']->params['format']['date'];
        return ($this->published_time == 0) ? date($format) : date($format, $this->published_time);
    }


    public static function dropDownList($group_id = 0)
    {
        return ArrayHelper::map(self::find_base()->group_id($group_id)->enabled()->all(), 'id', 'lang.title');
    }
        public static function dropDownListWithFilter($group_id = 0)
    {
        return ArrayHelper::map(self::find_base()->where(['filter'=>'1'])->group_id($group_id)->all(), 'id', 'lang.title');
    }


    /**
     *  ISO8601 = "Y-m-d\TH:i:sO"
     * @return string
     */
    public function getPublishedTimeISO() {
        return date('Y-m-d\TH:i:sO', $this->published_time);
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->hasMany(self::class, ['group_id' => 'id'])->undeleted();
    }

    /**
     * @return mixed
     */
    public function getParentModel($group_id = null)
    {
        return self::find_base()->byId($group_id)->one();
    }

}
