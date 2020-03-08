<?php

use yii\db\Migration;

/**
 * Handles adding token to table `transfer_booking`.
 */
class m160520_111418_add_token_to_transfer_booking extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%company_transfer_orders}}', 'token', 'varchar(255) NOT NULL DEFAULT \'\' COMMENT \'токен\'');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%company_transfer_orders}}', 'token');
    }
}
