<?php

class m131020_203845_big_work_title extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m131020_203845_big_work_title does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->addColumn('Projects', 'titleBig', "varchar(255) NOT NULL COMMENT 'Заголовок большой работы' AFTER `title`");
        $this->addColumn('Projects', 'descBig', "varchar(255) NOT NULL COMMENT 'Описание большой работы' AFTER `titleBig`");
        $this->execute('
            UPDATE `Projects` SET `titleBig` = `title`, `descBig` = `desc`;
        ');
    }

    public function safeDown()
    {
        $this->dropColumn('Projects', 'titleBig');
        $this->dropColumn('Projects', 'descBig');
    }
}