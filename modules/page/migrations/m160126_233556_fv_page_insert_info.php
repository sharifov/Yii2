<?php

use yii\db\Migration;
use thread\modules\page\Page;

/**
 * Class m160126_233556_fv_page_insert_info
 *
 * @package thread\modules\page
 * @author FilamentV <vortex.filament@gmail.com>
 * @copyright (c) 2015, Thread
 */

class m160126_233556_fv_page_insert_info extends Migration {

    /**
     *
     * @var type
     */
    public $tablePage = 'fv_page';

    /**
     *
     * @var type
     */
    public $tablePageLang = 'fv_page_lang';

    /**
     *
     */
    public function init() {

        $this->db = Page::getDb();
        parent::init();
    }

    /**
     *
     */
    public function safeUp() {
        $this->execute("
            INSERT INTO `" . $this->tablePage . "` (`id`, `alias`, `image_link`, `create_time`, `update_time`, `published`, `deleted`) VALUES
                (1, 'start', '552d9e6627a4c.jpg', 1408975581, 1446666057, '1', '0'),
                (2, 'about', '', 1408978707, 1454079305, '1', '0'),
                (3, 'pomoschj-v-oformlenii-vizi', '', 1410702707, 1454065240, '1', '0'),
                (4, 'konsuljtatsiya-vrachey', NULL, 1453996871, 1454065263, '1', '0'),
                (5, 'zakazatj-transfer', NULL, 1454063749, 1454065283, '1', '0'),
                (6, 'kak-praviljno-vibratj-sanatoriy', NULL, 1454063801, 1454065302, '1', '0'),
                (7, 'o-kompanii', NULL, 1454078410, 1454078410, '1', '0'),
                (8, 'poljzovateljskoe-soglashenie', NULL, 1454078636, 1454342478, '1', '0');
        ");

        $this->execute("
            INSERT INTO `" . $this->tablePageLang . "` (`rid`, `lang`, `title`, `content`) VALUES
                (1, 'en-EN', 'startpage', ''),
                (1, 'ru-RU', 'Стартовая страница', ''),
                (1, 'uk-UA', 'Стартова сторінка', ''),
                (2, 'ru-RU', 'О нас', '<p>Adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</p>'),
                (3, 'ru-RU', 'Помощь в оформлении визы', '<p>Adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</p>'),
                (4, 'ru-RU', 'Консультация врачей', '<p>Adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</p>'),
                (5, 'ru-RU', 'Заказать трансфер', '<p>Adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</p>'),
                (6, 'ru-RU', 'Как правильно выбрать санаторий', '<p>Adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\r\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione</p>'),
                (7, 'ru-RU', 'О компании', '<pre style=\"font-family: ''Courier New'';\">О компании</pre>'),
                (8, 'ru-RU', 'Пользовательское соглашение', '<pre style=\"font-family: ''Courier New'';\">Пользовательское соглашение</pre>');
        ");

        parent::safeUp();
    }

    /**
     *
     */
    public function safeDown() {
        $this->delete($this->tablePage);

        parent::safeDown();
    }

}
