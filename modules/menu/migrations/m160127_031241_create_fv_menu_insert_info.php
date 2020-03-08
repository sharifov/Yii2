<?php

use yii\db\Migration;
use thread\modules\menu\Menu;

/**
 * Class m160127_031241_create_fv_menu_insert_info
 *
 * @package thread\modules\menu
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */
class m160127_031241_create_fv_menu_insert_info extends Migration {

    /**
     *
     * @var type
     */
    public $tableMenu = 'fv_menu';

    /**
     *
     * @var type
     */
    public $tableMenuLang = 'fv_menu_lang';

    /**
     *
     * @var type
     */
    public $tableMenuItem = 'fv_menu_item';

    /**
     *
     * @var type
     */
    public $tableMenuItemLang = 'fv_menu_item_lang';

    /**
     *
     */
    public function init() {

        $this->db = Menu::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp() {

        $this->execute("
            INSERT INTO `".$this->tableMenu."` (`id`, `alias`, `create_time`, `update_time`, `published`, `deleted`, `readonly`) VALUES
                (1, 'main', 1410813032, 1428616750, '1', '0', '0'),
                (2, 'about', 1410815508, 1454077987, '1', '0', '0');
        ");

        $this->execute("
            INSERT INTO `".$this->tableMenuLang."` (`rid`, `lang`, `title`) VALUES
                (1, 'en-EN', 'main menu'),
                (1, 'ru-RU', 'главное меню'),
                (1, 'uk-UA', 'головне меню'),
                (2, 'en-EN', 'menu about'),
                (2, 'ru-RU', 'меню about'),
                (2, 'uk-UA', 'меню about');
        ");
        
        $this->execute("
            INSERT INTO `".$this->tableMenuItem."` (`id`, `group_id`, `type`, `link`, `position`, `create_time`, `update_time`, `published`, `deleted`, `link_type`, `link_target`, `internal_source`, `internal_source_id`) VALUES
                (1, 1, 'normal', '/page/actions', 0, 1410813837, 1454078184, '1', '1', 'internal', '_self', 'page', 19),
                (2, 1, 'normal', '', 0, 1453995743, 1454074994, '1', '0', 'internal', '_self', 'page', 2),
                (3, 1, 'normal', '', 0, 1453996917, 1454075060, '1', '0', 'internal', '_self', 'page', 3),
                (4, 1, 'normal', '', 0, 1453996945, 1454063847, '1', '0', 'internal', '_self', 'page', 4),
                (5, 1, 'normal', '', 0, 1454063880, 1454063880, '1', '0', 'internal', '_self', 'page', 5),
                (6, 1, 'normal', '', 0, 1454063927, 1454063927, '1', '0', 'internal', '_self', 'page', 6),
                (7, 2, 'normal', '', 0, 1454078777, 1454078777, '1', '0', 'internal', '_self', 'page', 7),
                (8, 2, 'normal', '/faq', 0, 1454078798, 1454341486, '1', '0', 'internal', '_self', 'page', 0),
                (9, 2, 'normal', '', 0, 1454342511, 1454342511, '1', '0', 'internal', '_self', 'page', 8);
        ");
        
        $this->execute("
            INSERT INTO `".$this->tableMenuItemLang."` (`rid`, `lang`, `title`) VALUES
                (1, 'en-EN', 'Menu'),
                (1, 'ru-RU', 'Меню'),
                (1, 'uk-UA', 'Меню'),
                (2, 'ru-RU', 'О нас'),
                (3, 'ru-RU', 'Помощь в оформлении визы'),
                (4, 'ru-RU', 'Консультация врачей'),
                (5, 'ru-RU', 'Заказать трансфер'),
                (6, 'ru-RU', 'Как правильно выбрать санаторий'),
                (7, 'ru-RU', 'О компании'),
                (8, 'ru-RU', 'Часто задаваемы вопросы'),
                (9, 'ru-RU', 'Пользовательское соглашение');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tableMenu);

        parent::safeDown();
    }

}
