<?php

use yii\db\Migration;

class m160216_092828_switchIndex_lang_table extends Migration
{
    private $table = 'fv_manual_rooms';
    private $tableLang = 'fv_manual_rooms_lang';

    private $table2 = 'fv_manual_medical_base';
    private $tableLang2 = 'fv_manual_medical_base_lang';

    private $table3 = 'fv_manual_services';
    private $tableLang3 = 'fv_manual_services_lang';

    private $table4 = 'fv_news_article';
    private $tableLang4 = 'fv_news_article_lang';

    private $table5 = 'fv_news_group';
    private $tableLang5 = 'fv_news_group_lang';

    private $table6 = 'fv_sanatorium_sanatoriums';
    private $tableLang6 = 'fv_sanatorium_sanatoriums_lang';


    public function up()
    {
        $this->execute("
            ALTER TABLE `". $this->tableLang ."`
                DROP FOREIGN KEY `" .$this->tableLang ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang ."`
                 ADD CONSTRAINT `". $this->tableLang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
            ALTER TABLE `". $this->tableLang2 ."`
                DROP FOREIGN KEY `" .$this->tableLang2 ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang2 ."`
                 ADD CONSTRAINT `". $this->tableLang2 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table2 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
            ALTER TABLE `". $this->tableLang3 ."`
                DROP FOREIGN KEY `" .$this->tableLang3 ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang3 ."`
                 ADD CONSTRAINT `". $this->tableLang3 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table3 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");


        $this->execute("
            ALTER TABLE `". $this->tableLang4 ."`
                DROP FOREIGN KEY `" .$this->tableLang4 ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang4 ."`
                 ADD CONSTRAINT `". $this->tableLang4 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table4 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");


        $this->execute("
            ALTER TABLE `". $this->tableLang5 ."`
                DROP FOREIGN KEY `" .$this->tableLang5 ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang5 ."`
                 ADD CONSTRAINT `". $this->tableLang5 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table5 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");



        $this->execute("
            ALTER TABLE `". $this->tableLang6 ."`
                DROP FOREIGN KEY `" .$this->tableLang6 ."_ibfk_1`
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang6 ."`
                 ADD CONSTRAINT `". $this->tableLang6 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table6 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");
    }

    public function down()
    {
        $this->execute("
              ALTER TABLE `". $this->tableLang ."`
                 ADD CONSTRAINT `". $this->tableLang ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang2 ."`
                 ADD CONSTRAINT `". $this->tableLang2 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table2 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang3 ."`
                 ADD CONSTRAINT `". $this->tableLang3 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table3 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang4 ."`
                 ADD CONSTRAINT `". $this->tableLang4 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table4 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang5 ."`
                 ADD CONSTRAINT `". $this->tableLang5 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table5 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");

        $this->execute("
              ALTER TABLE `". $this->tableLang6 ."`
                 ADD CONSTRAINT `". $this->tableLang6 ."_ibfk_1` FOREIGN KEY (`rid`) REFERENCES `". $this->table6 ."` (`id`)
                 ON DELETE CASCADE ON UPDATE RESTRICT
         ");


    }
}
