<?php

namespace thread\modules\page\models;

use frontend\modules\manual\widgets\OutteamListWidget;
use frontend\modules\manual\widgets\FaqWidget;
use frontend\modules\manual\widgets\AdvantagesWidget;
use frontend\modules\home\widgets\FormAskQuestionWidget;
use frontend\widgets\forms\VizaFormWidget;
use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\TransliterateBehavior;
use yii\helpers\Url;

/**
 * Class Page
 *
 * @package thread\modules\page\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Page extends \thread\models\ActiveRecord {

    const PAGE_RESORT = 'page_resort';

    /**
     *
     * @return string
     */
    public static function getDb() {
        return \thread\modules\page\Page::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName() {
        return '{{%page}}';
    }

    /**
     * 
     * @return array
     */
    public function behaviors() {
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
    public function rules() {
        return [
            [['alias'], 'required'],
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'update_time', 'item_id'], 'integer'],
            [['alias', 'widget', 'layout', 'image_link'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'backend' => ['alias', 'widget', 'layout', 'image_link', 'item_id', 'published', 'deleted'],
        ];
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'alias' => Yii::t('app', 'alias'),
            'layout' => Yii::t('app', 'layout'),
            'image_link' => Yii::t('app', 'image_link'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
            'widget' => Yii::t('app', 'widget'),
            'item_id' => Yii::t('app', 'item_id'),
        ];
    }

    /**
     *
     * @return ActiveQuery
     */
    public function getLang() {
        return $this->hasOne(PageLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getImageLinkUrl() {
        return Yii::$app->modules['page']->getImageBaseUrl() . '/' . $this->image_link;
    }

    /**
     * 
     * @return type
     */
    public static function getWidgetDropDownList() {
        return [
            '' => Yii::t('app', 'KEY_OFF'),
            OutteamListWidget::class => Yii::t('app', 'Outteam'),
            FaqWidget::class => Yii::t('app', 'Question / Answer'),
            AdvantagesWidget::class => Yii::t('app', "Advantages"),
            FormAskQuestionWidget::class => Yii::t('app', 'Form to ask a question'),
            VizaFormWidget::class => Yii::t('app', 'Visa support request'),
            self::PAGE_RESORT => Yii::t('app', 'The selection page of the resort')
        ];
    }


    /**
     *
     * @param integer $id
     * @return ActiveRecord|null
     */
    public static function findWithWidget($widgetPath) {
        return self::find_base()->andWhere(['widget' => $widgetPath])->one();
    }

    /**
     *
     * @return string
     */

    public function getUrl($scheme = false) {
        return Url::toRoute(['/page/page/view', 'alias' => $this->alias], $scheme);
    }

}
