<?php

namespace thread\modules\news\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\behaviors\PurifierBehavior;

/**
 * Class ArticleLang
 *
 * @package thread\modules\news\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ArticleLang extends \thread\models\ActiveRecordLang {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\news\News::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%news_article_lang}}';
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
                            \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['content', 'description'],
                            \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['content', 'description'],
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
                    ['rid', 'exist', 'targetClass' => Article::class, 'targetAttribute' => 'id'],
                    ['title', 'string', 'max' => 255],
                    ['content', 'string'],
                    [['title', 'description', 'meta_keywords'], 'string', 'max' => 255],
                    [['meta_title'], 'string', 'max' => 288],
                    [['meta_description'], 'string', 'max' => 255],
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
            'description' => Yii::t('app', 'description'),
            'content' => Yii::t('app', 'content'),
        ];
    }

    /**
     * 
     * @return array
     */
    public function scenarios() {
        return [
            'backend' => ['title', 'description', 'content','meta_title', 'meta_description', 'meta_keywords'],
        ];
    }

}
