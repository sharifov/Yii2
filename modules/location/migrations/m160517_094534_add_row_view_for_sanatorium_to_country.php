<?php

use yii\db\Migration;

/**
 * Handles adding row_view_for_sanatorium to table `country`.
 */
class m160517_094534_add_row_view_for_sanatorium_to_country extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('fv_location_country', 'view_for_sanatorium', 'tinyint(1) NOT NULL DEFAULT \'0\' COMMENT \'Отображать в списку санаториих и поиске\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('fv_location_country', 'view_for_sanatorium');
    }
}
