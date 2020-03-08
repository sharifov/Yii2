<?php

use yii\db\Migration;

/**
 * Handles adding column_accept_bank_cards to table `sanatoriums`.
 */
class m160504_110421_add_column_accept_bank_cards_to_sanatoriums extends Migration
{
    public $tableName = '{{%sanatorium_sanatoriums}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'accept_bank_cards', $this->string(255)->defaultValue(null) . ' COMMENT "Accept bank cards"');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'accept_bank_cards');
    }
}
