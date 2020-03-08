<?php

use yii\db\Migration;

class m160321_093923_delete_unique_alias_from_fv_sanatorium_room_type extends Migration
{
    public function up()
    {
        $this->dropIndex('alias', 'fv_sanatorium_room_type');

    }

    public function down()
    {
        $this->createIndex('alias', 'fv_sanatorium_room_type', 'alias', true);
    }

}
