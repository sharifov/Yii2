<?php

use yii\db\Migration;

/**
 * Handles adding row_scenery_from_room_id to table `sanroomtype`.
 */
class m160427_114657_add_row_scenery_from_room_id_to_sanRoomtype extends Migration
{

    public  $tableName = '{{%sanatorium_room_type}}';
    public $firstIndexName = 'fv_sanatorium_room_type_scenery_from_room_idibfk_1';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn($this->tableName, 'scenery_from_room_id', 'int(11) unsigned COMMENT \'Вид из номера\'');
        $this->dropColumn($this->tableName, 'room_view');

//        $this->addForeignKey(
//            $this->firstIndexName,
//            $this->tableName,
//            'scenery_from_room_id',
//            'fv_manual_scenery_from_room',
//            'id',
//            'CASCADE'
//        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
//        $this->dropForeignKey($this->firstIndexName, $this->tableName);
        $this->dropColumn($this->tableName, 'scenery_from_room_id');
        $this->addColumn($this->tableName, 'room_view', 'int(11) unsigned COMMENT \'Вид из номера\'');
    }
}
