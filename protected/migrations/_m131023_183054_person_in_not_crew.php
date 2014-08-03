<?php

class m131023_183054_person_in_not_crew extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m131023_183054_person_in_not_crew does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('Persons', 'showInCommand', "tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Отображать в команде' AFTER `photoBig`");
    }

    public function safeDown()
    {
        $this->dropColumn('Persons', 'showInCommand');
    }
}