<?php

use yii\db\Migration;

class m160309_133048_add_column_to_fv_sanatorium_sanatoriums_gallery_link extends Migration
{
    public function up()
    {
        $this->addColumn('fv_sanatorium_sanatoriums', 'gallery_link', 'text AFTER address_map');
    }

    public function down()
    {
        $this->dropColumn('fv_sanatorium_sanatoriums', 'gallery_link');
    }
}
