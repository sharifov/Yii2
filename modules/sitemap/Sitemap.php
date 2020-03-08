<?php

namespace thread\modules\sitemap;

use Yii;

/**
 * Class Sitemap
 *
 * @package app\modules\sitemap
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class Sitemap extends \thread\base\Module  {

    /**
      'objects' => [
      'video' => [
      'item' => \app\modules\page\models\Page::class,
      ],
      ]
     * @var type 
     */
    public $objects = [];
    public $secretKey = 'thread';
    public $title = "Sitemap";
    public $name = 'sitemap';
    public $translationsBasePath = __DIR__ . '/messages';
    public $configPath = __DIR__ . '/config.php';

    public static function getDb() {
        return Yii::$app->get('coredb');
    }



}
