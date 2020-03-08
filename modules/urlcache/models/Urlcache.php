<?php

namespace thread\modules\urlcache\models;

use Yii;
use yii\helpers\ArrayHelper;
use thread\modules\user\models\User;
use admin\modules\location\models\Country;
use thread\modules\sanatorium\models\Sanatoriums;

/**
 * Class Company
 *
 * @package thread\modules\company\models
 */
class Urlcache extends \thread\models\ActiveRecord
{
    /**
     *
     * @return string
     */
    public static function getDb()
    {
        return \thread\modules\urlcache\Urlcache::getDb();
    }

    /**
     *
     * @return string
     */
    public static function tableName()
    {
        return '{{%urlcache}}';
    }


    /**
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['published', 'deleted'], 'in', 'range' => array_keys(static::statusKeyRange())],
            [['cleaning', 'create_time', 'update_time'], 'integer'],
            [['hash'], 'string', 'max' => 255],
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
            'backend' => ['cleaning', 'hash', 'published', 'deleted'],
        ];
    }

    /**
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cleaning' => Yii::t('app', 'cleaning'),
            'hash' => Yii::t('app', 'hash'),
            'create_time' => Yii::t('app', 'create_time'),
            'update_time' => Yii::t('app', 'update_time'),
            'published' => Yii::t('app', 'published'),
            'deleted' => Yii::t('app', 'deleted'),
        ];
    }


    /**
     *
     * Получить время очистки кеширования
     *
     * @param $currentUrl
     * @param $time
     * @param $format (s - секунды, m - минуты , h - часы)
     */

    public static function getCacheClearTime($currentUrl, $time, $format = 's')
    {
        $cleaningTime = false;
        $cache = self::getByUrl($currentUrl);


        switch ($format) {

            case('s'): {
                $cleaningTime = time() + $time;
                break;
            }

            case('m'): {
                $cleaningTime = time() + $time * 60;
                break;
            }

            case('h'): {
                $cleaningTime = time() + $time * 60 * 60;
                break;
            }

            default: {
                $cleaningTime = time() + $time;
            }

        }

        if ($cache === null) {
            $cache = self::createCache($currentUrl, $cleaningTime);
        }


        $cache->updateCacheTime($cleaningTime);

        return $cache->cleaning;
    }


    /**
     * Обновить время хеша
     */

    public function updateCacheTime($time)
    {
        if ($this->cleaning < time()) {
            $this->setScenario('backend');
            $this->cleaning = $time;
            return $this->save();
        }

        return true;
    }


    /**
     * @param $currentUrl
     * @param $time
     * @return bool
     */

    public static function createCache($currentUrl, $time)
    {
        $cache = new self(['scenario' => 'backend']);
        $cache->hash = $currentUrl;
        $cache->cleaning = $time;
        $cache->save();

        return $cache;
    }


    /**
     * Получить кэш по url
     * @param $currentUrl
     * @return mixed
     */

    public static function getByUrl($currentUrl)
    {
        return self::find_base()->andWhere(['hash' => $currentUrl])->one();
    }

}
