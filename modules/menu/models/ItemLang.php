<?php

namespace thread\modules\menu\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class ItemLang
 *
 * @package thread\modules\menu\models
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class ItemLang extends \thread\models\ActiveRecordLang {

    /**
     * 
     * @return string
     */
    public static function getDb() {
        return \thread\modules\menu\Menu::getDb();
    }

    /**
     * 
     * @return string
     */
    public static function tableName() {
        return '{{%menu_item_lang}}';
    }

    /**
     * 
     * @return array
     */
    public function rules() {
        return ArrayHelper::merge(parent::rules(), [
                    [['title'], 'required'],
                    ['rid', 'exist', 'targetClass' => Item::class, 'targetAttribute' => 'id'],
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
        ];
    }

}
