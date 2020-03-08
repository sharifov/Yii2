<?php

use yii\db\Migration;

/**
 * Handles adding column_viza to table `countries`.
 */
class m160504_094131_add_column_visa_to_countries extends Migration
{
    public $tableName = '{{%location_country}}';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'visa', $this->boolean()->notNull()->defaultValue(0) . ' COMMENT "Нужна виза"');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'visa');
    }
}
