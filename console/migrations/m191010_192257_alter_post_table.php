<?php

use yii\db\Migration;

class m191010_192257_alter_post_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%post}}', 'main_flag', $this->integer(1)->defaultValue(0));
    }

    public function safeDown()
    {
       
        $this->dropColumn('{{%user}}', 'main_flag');
    }
}