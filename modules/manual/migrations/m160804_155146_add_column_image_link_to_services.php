<?php

use yii\db\Migration;

/**
 * Handles adding column_image_link to table `services`.
 */
class m160804_155146_add_column_image_link_to_services extends Migration
{
    public $tableName = '{{%manual_hotel_options}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'image_link', $this->string(255)->defaultValue(null));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'image_link');
    }
}
