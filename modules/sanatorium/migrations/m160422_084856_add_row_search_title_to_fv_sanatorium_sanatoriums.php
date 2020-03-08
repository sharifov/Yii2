<?php

use yii\db\Migration;

/**
 * Handles adding row_search_title to table `fv_sanatorium_sanatoriums`.
 */
class m160422_084856_add_row_search_title_to_fv_sanatorium_sanatoriums extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'search_title', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'Заголовок для поиска\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'search_title');
    }
}
