<?php

use yii\db\Migration;

class m160225_145238_fix_lang_cunsultant extends Migration
{
    public function up()
    {

        $this->execute("
            ALTER TABLE `fv_manual_advantages_lang`
                DROP FOREIGN KEY `fv_manual_advantages_lang_ibfk_1`
        ");

          $this->execute("
            ALTER TABLE `fv_manual_advantages_lang`
                ADD CONSTRAINT `fv_manual_advantages_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `fv_manual_advantages` (`id`) ON DELETE CASCADE
        ");

    }

    public function down()
    {
        $this->execute("
            ALTER TABLE `fv_manual_advantages_lang`
                DROP FOREIGN KEY `fv_manual_advantages_lang_ibfk_1`
        ");

        $this->execute("
            ALTER TABLE `fv_manual_advantages_lang`
                ADD CONSTRAINT `fv_manual_advantages_lang_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `fv_manual_advantages` (`id`) ON DELETE CASCADE
        ");
    }


}
