<?php

use yii\db\Migration;

class m160304_151141_fix_db_manual_lang extends Migration
{
    public function up()
    {

        $this->execute("
            ALTER TABLE `fv_manual_types_food_lang`
                DROP FOREIGN KEY `fv_manual_types_food_lang_ibfk_1`
        ");

        $this->execute("
            ALTER TABLE `fv_manual_types_food_lang`
                ADD CONSTRAINT `fv_manual_types_food_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `fv_manual_types_food` (`id`) ON DELETE CASCADE
        ");



    }

    public function down()
    {

        $this->execute("
            ALTER TABLE `fv_manual_types_food_lang`
                DROP FOREIGN KEY `fv_manual_types_food_lang_ibfk_1`
        ");

        $this->execute("
            ALTER TABLE `fv_manual_types_food_lang`
                ADD CONSTRAINT `fv_manual_types_food_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `fv_manual_types_food` (`id`) ON DELETE CASCADE
        ");
    }
}
