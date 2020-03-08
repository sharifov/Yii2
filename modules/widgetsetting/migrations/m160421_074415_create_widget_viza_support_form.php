<?php

use yii\db\Migration;

/**
 * Handles the creation for table `widget_viza_support_form`.
 */
class m160421_074415_create_widget_viza_support_form extends Migration
{

    public $tableName = '{{%widget_viza_support_form}}';
    public $countyTableName = '{{%location_country}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull() . ' COMMENT "First name"',
            'phone' => $this->string()->notNull() . ' COMMENT "Phone"',
            'email' => $this->string()->notNull() . ' COMMENT "E-mail"',
            'your_country' => $this->integer(11)->notNull()->unsigned() . ' COMMENT "Your country"',
            'country_viza' => $this->integer(11)->notNull()->unsigned() . ' COMMENT "Country viza"',
            'create_time' => $this->integer(11)->notNull()->defaultValue(0) . ' COMMENT "Create time"',
            'update_time' => $this->integer(11)->notNull()->defaultValue(0) . ' COMMENT "Update time"',
            'published' => "enum('0', '1') NOT NULL DEFAULT '0' COMMENT 'Published'",
            'deleted' => "enum('0', '1') NOT NULL DEFAULT '0' COMMENT 'Deleted'",
        ]);

        $this->createIndex('countryIndex', $this->tableName, ['your_country', 'country_viza']);

        $this->addForeignKey(
            'fk_widget_viza_form_your_country_location_country_id',
            $this->tableName,
            'your_country',
            $this->countyTableName,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_widget_viza_form_country_viza_location_country_id',
            $this->tableName,
            'country_viza',
            $this->countyTableName,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_widget_viza_form_country_viza_location_country_id', $this->tableName);
        $this->dropForeignKey('fk_widget_viza_form_your_country_location_country_id', $this->tableName);
        $this->dropIndex('countryIndex', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
