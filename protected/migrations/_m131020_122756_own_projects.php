<?php

class m131020_122756_own_projects extends CDbMigration
{
/*  public function up()
    {
    }

    public function down()
    {
        echo "m130920_104605_vacancy does not support migration down.\n";
        return false;
    }*/

    public function safeUp()
    {
        $this->dropColumn('ProjectsOwn', 'link');
        $this->dropColumn('ProjectsOwn', 'type');
    }

    public function safeDown()
    {
        $this->addColumn('ProjectsOwn', 'link', 'varchar(100) NOT NULL');
        $this->addColumn('ProjectsOwn', 'type', 'int(11) NOT NULL DEFAULT "0"');
    }
}