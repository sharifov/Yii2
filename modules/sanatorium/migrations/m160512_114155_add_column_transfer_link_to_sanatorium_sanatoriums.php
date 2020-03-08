<?php

use yii\db\Migration;

/**
 * Handles adding column_transfer_link to table `sanatorium_sanatoriums`.
 */
class m160512_114155_add_column_transfer_link_to_sanatorium_sanatoriums extends Migration
{
    public $tableName = '{{%sanatorium_sanatoriums}}';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'transfer_link', $this->string()->defaultValue(null) . ' COMMENT "Transfer link"');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'transfer_link');
    }
}
