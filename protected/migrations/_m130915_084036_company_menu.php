<?php

class m130915_084036_company_menu extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m130911_204303_footer_menu does not support migration down.\n";
        return false;
    }*/

    
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute('INSERT INTO Menu (`id`,`name`,`visible`) VALUES (3,"Меню в компании",1);');
    }

    public function safeDown()
    {
        $this->execute('DELETE FROM Menu WHERE Id = 3');
    }
}