<?php

use yii\db\Migration;
use thread\modules\location\Location;

/**
 * Class m160127_132752_create_fv_location_language_insert_info
 *
 * @package thread\modules\location
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_132752_create_fv_location_language_insert_info extends Migration {

    /**
     *
     * @var type
     */
    public $tableLocationLanguage = 'fv_location_language';

    /**
     *
     */
    public function init() {

        $this->db = Location::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            INSERT INTO `" . $this->tableLocationLanguage . "` (`id`, `alias`, `title`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 'ukrainian', 'українська', 1422206105, 1427837760, '1', '0'),
                (2, 'english', 'english', 1422206146, 1422206146, '1', '0'),
                (3, 'russian', 'русский', 1422206186, 1422206186, '1', '0');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableLocationLanguage);

        parent::safeDown();
    }

}
