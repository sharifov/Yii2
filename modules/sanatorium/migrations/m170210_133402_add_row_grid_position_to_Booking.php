<?php

use yii\db\Migration;

/**
 * Handles adding row_grid_position to table `booking`.
 */
class m170210_133402_add_row_grid_position_to_Booking extends Migration
{
    public $table = '{{%sanatorium_booking}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn($this->table, 'position_grid', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn($this->table, 'position_grid');
    }
}
