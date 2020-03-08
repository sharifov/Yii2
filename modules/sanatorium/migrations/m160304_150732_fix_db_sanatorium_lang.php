<?php

use yii\db\Migration;

class m160304_150732_fix_db_sanatorium_lang extends Migration
{
    public function up()
    {

        $this->execute("
            ALTER TABLE `fv_sanatorium_room_type_lang`
                DROP FOREIGN KEY `fv_sanatorium_room_type_lang_ibfk_1`
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_room_type_lang`
                ADD CONSTRAINT `fv_sanatorium_room_type_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `fv_sanatorium_room_type` (`id`) ON DELETE CASCADE
        ");

    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_sanatorium_room_type_lang`
                DROP FOREIGN KEY `fv_sanatorium_room_type_lang_ibfk_1`
        ");

        $this->execute("
            ALTER TABLE `fv_sanatorium_room_type_lang`
                ADD CONSTRAINT `fv_sanatorium_room_type_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `fv_sanatorium_room_type` (`id`) ON DELETE CASCADE
        ");
    }

}
