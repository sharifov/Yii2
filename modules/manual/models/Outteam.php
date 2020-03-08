<?php

namespace thread\modules\manual\models;

use Yii;

/**
 * Class Article
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Outteam extends \thread\models\ActiveRecord
{

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
        return '{{%manual_our_team}}';
    }


    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['create_time', 'position', 'update_time'], 'integer'],
            ['position', 'default', 'value' => 0],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
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
            'backend' => ['image_link', 'position', 'published', 'deleted', 'published_time'],
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
            'image_link' => Yii::t('app', 'image_link'),
            'published_time' => Yii::t('app', 'published_time'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'Outteam' => Yii::t('app', 'Outteam'),
            'position' => Yii::t('app', 'position'),
        ];
    }


    /**
     *
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(OutteamLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getImageBaseUrl()
    {
        return Yii::$app->request->hostInfo . '/frontend/upload/manual/outteam';
    }

    /**
     *
     * @return string
     */
    public function getImageLinkUrl()
    {
        return ($this->image_link) ? $this->getImageBaseUrl() . '/' . $this->image_link : '';
    }

///frontend/upload/manual/outteam

}
