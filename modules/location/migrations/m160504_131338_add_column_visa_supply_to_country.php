<?php

use yii\db\Migration;

/**
 * Handles adding column_visa_supply to table `country`.
 */
class m160504_131338_add_column_visa_supply_to_country extends Migration
{
    public $tableName = '{{%location_country}}';
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'visa_supply', $this->boolean()->notNull()->defaultValue(0) . ' COMMENT "Страна подачи визы"');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'visa_supply');
    }
}
