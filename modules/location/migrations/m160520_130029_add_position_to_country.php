<?php

use yii\db\Migration;

/**
 * Handles adding position to table `country`.
 */
class m160520_130029_add_position_to_country extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%location_country}}', 'position', 'int(11) NOT NULL DEFAULT 0 COMMENT\'position\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%location_country}}');
    }
}
