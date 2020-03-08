<?php

use yii\db\Migration;

/**
 * Handles adding column_filter to table `room_fac`.
 */
class m160511_123200_add_column_filter_to_room_fac extends Migration
{

    public $tableName = '{{%manual_facilities_rooms}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'filter', $this->boolean()->defaultValue(0) . ' COMMENT "Filter"');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'filter');
    }
}
