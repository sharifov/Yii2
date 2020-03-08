<?php

use yii\db\Migration;

/**
 * Handles adding row_country_id to table `fv_sanatorium_comments`.
 */
class m160415_133247_add_row_country_id_to_fv_sanatorium_comments extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_sanatorium_comments', 'country_id', 'int(11) unsigned COMMENT\'страна\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_sanatorium_comments', 'country_id');
    }

}
