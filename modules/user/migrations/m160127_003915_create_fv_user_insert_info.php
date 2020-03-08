<?php

use yii\db\Migration;
use thread\modules\user\User;

/**
 * Class m160127_003915_create_fv_user_insert_info
 *
 * @package thread\modules\user
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_003915_create_fv_user_insert_info extends Migration {

    /**
     *
     * @var type
     */
    public $tableUser = 'fv_user';

    /**
     *
     * @var type
     */
    public $tableUserProfile = 'fv_user_profile';

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
            INSERT INTO `" . $this->tableUser . "` (`id`, `group_id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 1, 'admin', 'en-28w3o9k8J2NoyWFRIPLjEYjH10rQY', '$2y$13\$jxhE/G4ITbvhJlS0jOpErO1lw.IvJ2NXT/ZzVPHa144qG0G7vYpU2', NULL, 'admin@admin.com', 10, 1402958717, 1454499172, '1', '0'),
                (2, 3, 'admin_company', 'Adq2hdC8hivtIhHi6onmbusDpN6zCxe4', '$2y$13\$wrYU3AF/U4JN6QXQd090lOmdgcGUortizE.L9kt0ka0dOGz0S.lkO', NULL, 'admin_company@test.com', 10, 1454602909, 1454934217, '1', '0'),
                (6, 4, 'admin_sanatorium', 'x__2dFe-YTfccjGpvGKzViX0I_fhxATm', '$2y$13\$r379ID.4mqjF4rqEgtkcHOLGchFDiRdngPDihyey7UNPiE.PfCEz.', NULL, 'admin_sanatorium@test.com', 10, 1454947519, 1454947573, '1', '0');
        ");

        $this->execute("
            INSERT INTO `" . $this->tableUserProfile . "` (`id`, `user_id`, `company_id`, `name`, `surname`, `image_link`, `preferred_language`, `create_time`, `update_time`) VALUES
                (1, 1, 0, 'name13', 'surname234', '', 'ru-RU', 1429405870, 1429407679),
                (2, 2, 9, 'name', 'surname23', '', 'en-EN', 0, 1454934219),
                (3, 6, 9, 'name', 'surname', '', 'en-EN', 1454947519, 1454947519);
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableName);

        parent::safeDown();
    }

}
