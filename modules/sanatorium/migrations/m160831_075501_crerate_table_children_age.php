<?php

use thread\modules\sanatorium\Sanatorium;
use yii\db\Migration;

class m160831_075501_crerate_table_children_age extends Migration
{
    /**
     * @var string
     */
    public $table = '{{%sanatorium_children_age}}';

    public $tableSanatorium = '{{%sanatorium_sanatoriums}}';


    /**
     * Implement migration
     */
    public function safeUp()
    {
        $this->createTable(
            $this->table,
            [
                'id' => $this->primaryKey()->unsigned(),
                'age_begin' => $this->integer(11)->notNull(),
                'age_end' => $this->integer(11)->notNull(),
                'sanatorium_id' => $this->integer(11)->notNull()->unsigned(),
                'position' => $this->integer(10)->notNull()->defaultValue(0),
                'create_time' => $this->integer(10)->notNull()->defaultValue(0),
                'update_time' => $this->integer(10)->notNull()->defaultValue(0),
                'published' => 'enum(\'0\',\'1\')  NOT NULL DEFAULT\'0\' ',
                'deleted' => 'enum(\'0\',\'1\') NOT NULL DEFAULT\'0\' ',
            ]
        );

        $this->createIndex('published', $this->table, 'published');
        $this->createIndex('deleted', $this->table, 'deleted');

        /** rel with table catalog_category */
        $this->addForeignKey(
            'fk-san_children_age_sanatorium_id-sanatorium_sanatoriums_id',
            $this->table,
            'sanatorium_id',
            $this->tableSanatorium,
            'id',
            'CASCADE',
            'CASCADE'
        );
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
