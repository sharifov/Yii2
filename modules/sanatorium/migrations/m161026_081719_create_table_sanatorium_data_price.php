<?php

use yii\db\Migration;

/**
 * Handles the creation for table `table_sanatorium_data_price`.
 */
class m161026_081719_create_table_sanatorium_data_price extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%sanatorium_dates_price}}';


    /** @var string санатории */
    public $tableSanatorium = '{{%sanatorium_sanatoriums}}';

    public $tableSanatoriumRoomType = '{{%sanatorium_room_type}}';

    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id' => $this->primaryKey()->unsigned(),
                'sanatorium_id' => $this->integer(11)->unsigned()->notNull(),
//                'sanatorium_room_type_id' => $this->integer(11)->unsigned()->notNull(),
                'begin_date' => $this->date(),
                'end_date' => $this->date(),
                'create_time' => $this->integer(10)->notNull()->defaultValue(0),
                'update_time' => $this->integer(10)->notNull()->defaultValue(0),
                'published' => 'enum(\'0\',\'1\')  NOT NULL DEFAULT\'0\' ',
                'deleted' => 'enum(\'0\',\'1\') NOT NULL DEFAULT\'0\' ',
            ]
        );

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');

        $this->addForeignKey(
            'fk-sanatorium_dates_price-sanatorium_id-sanatoriums_id',
            $this->table,
            'sanatorium_id',
            $this->tableSanatorium,
            'id',
            'CASCADE',
            'CASCADE'
        );

//
//        $this->addForeignKey(
//            'fk-san_dates_price-san_room_type_id-san_room_type_id',
//            $this->table,
//            'sanatorium_room_type_id',
//            $this->tableSanatoriumRoomType,
//            'id',
//            'CASCADE',
//            'CASCADE'
//        );
    }

    /**
     * Cancel migration
     */
    public function safeDown()
    {
        $this->dropIndex('deleted', $this->table);
        $this->dropIndex('published', $this->table);
        $this->dropTable($this->table);
    }
}
