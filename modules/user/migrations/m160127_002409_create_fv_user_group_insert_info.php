<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_002409_create_fv_user_group_insert_info
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_002409_create_fv_user_group_insert_info extends Migration {

    /**
     *
     * @var type
     */
    public $tableUserGroup = 'fv_user_group';

    /**
     *
     * @var type
     */
    public $tableUserGroupLang = 'fv_user_group_lang';

    /**
     *
     */
    public function init() {

        $this->db = User::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            INSERT INTO `" . $this->tableUserGroup . "` (`id`, `alias`, `role`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 'administrator', 'admin', 1408975581, 1409066008, '1', '0'),
                (2, 'user', 'user', 1408978707, 1409066018, '1', '0'),
                (3, 'admin_company', 'admin_company', 1454601500, 1454601500, '1', '0'),
                (4, 'admin_sanatorium', 'admin_sanatorium', 1454601625, 1454601625, '1', '0'),
                (5, 'worker_sanatorium', 'worker_sanatorium', 1454601986, 1454601986, '1', '0');
        ");

        $this->execute("
            INSERT INTO `" . $this->tableUserGroupLang . "` (`rid`, `lang`, `title`) VALUES
                (1, 'en-EN', 'Administrators'),
                (1, 'ru-RU', 'Администратор сайта'),
                (1, 'uk-UA', 'Адміністратори'),
                (2, 'en-EN', 'Users'),
                (2, 'ru-RU', 'Пользователь'),
                (2, 'uk-UA', 'Користувачі'),
                (3, 'ru-RU', 'Администратор компании'),
                (4, 'ru-RU', 'Администратор санатория'),
                (5, 'ru-RU', 'Работник санатория');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableUserGroup);

        parent::safeDown();
    }

}
