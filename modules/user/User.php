<?php

namespace thread\modules\user;

use Yii;

/**
 * Class User
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class User extends \thread\base\Module {

    public $title = 'User';
    public $name = 'user';
    public $configPath = __DIR__ . '/config.php';
    public $translationsBasePath = __DIR__ . '/messages';

    /**
     * range('email', 'username')
     * @var string
     */
    public $username_attribute = 'email';

    /**
     *
     * @return integer
     */
    public $password_min_length = 1;

    /**
     *
     * @var boolean
     */
    public $auto_login_after_register = true;

    /**
     * = 3600*24*30
     * @var integer
     */
    public $time_remember_user_sigin = 2592000;

    /**
     *
     * @return string
     */
    public static function getDb() {
        return Yii::$app->get('coredb');
    }

}
