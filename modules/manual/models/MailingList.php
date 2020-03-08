<?php

namespace thread\modules\manual\models;

use Yii;

class MailingList extends \thread\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manual_mailing_list}}';
    }

    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['create_time', 'update_time'], 'integer'],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'id'),
            'email' => Yii::t('app', 'email'),

            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }


    /**
     *
     * @return array
     */
    public function scenarios() {
        return [
            'published' => ['published'],
            'deleted'   => ['deleted'],
            'backend'   => ['position', 'create_time', 'update_time', 'published', 'email'],
        ];
    }

}
