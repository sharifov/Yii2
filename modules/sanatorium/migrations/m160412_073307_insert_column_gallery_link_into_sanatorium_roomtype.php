<?php

use yii\db\Migration;

class m160412_073307_insert_column_gallery_link_into_sanatorium_roomtype extends Migration
{

    /**
     * Main table
     * @var string
     */
    public $tableName = '{{%sanatorium_room_type}}';

    /**
     * Related language table
     * @var string
     */
    public $langTableName = '{{%sanatorium_room_type_lang}}';

    public function safeUp()
    {
        $this->addColumn($this->tableName, 'gallery_link', $this->text()->defaultValue(null) . ' COMMENT "Gallery link"');
        $this->addColumn($this->tableName, 'room_view', 'ENUM("Garden view", "Pool view", "Park view", "Mountain view", "Sea view", "River view", "Forest view", "Lake view", "Street view") COMMENT "Room view"');
        $this->addColumn($this->langTableName, 'room_features', $this->text()->defaultValue(null) . ' COMMENT "Room features"');
        $this->addColumn($this->langTableName, 'additional_room_features', $this->text()->defaultValue(null) . ' COMMENT "Additional room features"');
    }

    public function safeDown()
    {
        $this->dropColumn($this->langTableName, 'additional_room_features');
        $this->dropColumn($this->langTableName, 'room_features');
        $this->dropColumn($this->tableName, 'room_view');
        $this->dropColumn($this->tableName, 'gallery_link');
    }
}
