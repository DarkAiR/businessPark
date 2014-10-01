<?php

class m140926_120046_menu_icon extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m140926_120046_menu_icon does not support migration down.\n";
        return false;
    }*/

    public function safeUp()
    {
        $this->addColumn('MenuItem', 'image', "varchar(100) NOT NULL COMMENT 'Картинка'");
    }

    public function safeDown()
    {
        $this->dropColumn('MenuItem', 'image');
    }
}