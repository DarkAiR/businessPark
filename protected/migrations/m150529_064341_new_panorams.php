<?php

class m150529_064341_new_panorams extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('Panorama', 'version', 'int(11) not null default 1');
    }

    public function safeDown()
    {
        $this->dropColumn('Panorama', 'version');    }
}
