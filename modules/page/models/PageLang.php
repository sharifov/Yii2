<?php

namespace thread\modules\page\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

/**
 * Class PageLang
 *
 * @package thread\modules\page\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class PageLang extends \thread\models\ActiveRecordLang {

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
        return '{{%page_lang}}';
    }

    /**
     * 
     * @return array
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
                    'purifierBehavior' => [
                        'class' => PurifierBehavior::class,
                        'attributes' => [
                            \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['content'],
                            \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['content'],
                        ],
                    ],
        ]);
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return ArrayHelper::merge(parent::rules(), [
                    [['title'], 'required'],
                    ['rid', 'exist', 'targetClass' => Page::class, 'targetAttribute' => 'id'],
                    ['content', 'string'],
                    ['title', 'string', 'max' => 255],
        ]);
    }

    /**
     * 
     * @return array
     */
    public function attributeLabels() {
        return [
            'rid' => Yii::t('app', 'rid'),
            'lang' => Yii::t('app', 'lang'),
            'title' => Yii::t('app', 'title'),
            'content' => Yii::t('app', 'content'),
            'meta_title' => Yii::t('app', 'meta_title'),
            'meta_desc' => Yii::t('app', 'meta_desc'),
            'meta_keywords' => Yii::t('app', 'meta_keywords'),
            'meta_h1' => Yii::t('app', 'meta_h1')
        ];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'backend' => [
                'title',
                'content',
                'meta_title',
                'meta_desc',
                'meta_keywords',
                'meta_h1'
            ],
        ];
    }

}
