<?php

namespace thread\modules\widgetsetting\models;
use Yii;

class HowToHelpWidget extends \thread\models\ActiveRecord
{

    const fileUploadFolder = 'frontend/upload/widgetsetting/howtohelpwidget';
    
    const LINK_TYPE_LINK = 'link';
    const LINK_TYPE_POPUP = 'popup';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_how_to_help}}';
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [
                [
                    'position',
                    'create_time',
                    'update_time',
                ],
                'integer'
            ],
            [[ 'image_link', 'link', 'button_link', 'link_type'], 'string', 'max' => 255],
            [[ 'position', 'link'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link' => Yii::t('app', 'Link in head'),
            'position' => Yii::t('app', 'position'),
            'image_link' => Yii::t('app', 'image_link'),
            'published' => Yii::t('app', 'published'),
            'btn_name' => Yii::t('app', 'btn_name'),
            'button_link' => Yii::t('app', 'Link in button'),
            'link_type' => Yii::t('app', 'Link Type'),
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
                'link',
                'image_link',
                'position',
                'published',
                'btn_name',
                'button_link',
                'link_type'
            ],
        ];
    }

    public function getLang()
    {
        return $this->hasOne(HowToHelpWidgetLang::class, ['rid' => 'id']);
    }

    /**
     *
     * @return string
     */
    public function getGalleryBasePath()
    {
        return Yii::getAlias('@root') . '/'. self::fileUploadFolder;
    }

    /**
     *
     * @return boolean
     */
    public function getImageLinkUrl()
    {
        return ($this->image_link && is_file($this->getGalleryBasePath(). '/' . $this->image_link ))
            ? self::fileUploadFolder . '/' . $this->image_link
            : '';
    }
    
    public static function getLinkType()
    {
        return [
            self::LINK_TYPE_LINK => Yii::t('app', 'Link'), 
            self::LINK_TYPE_POPUP => Yii::t('app', 'Popup'),
        ];
    }

}
