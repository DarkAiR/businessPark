<?php

class m141105_124936_panorama_03_11_2014 extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `Panorama`
                (`createDate`, `swf`, `mov`)
            VALUES
                ('2014-11-03', '3_1', '3_1'),
                ('2014-11-03', '3_2', '3_2');
        ");
    }

    public function safeDown()
    {
        $this->execute("
        	DELETE FROM `Panorama` WHERE createDate = '2014-11-03';
        ");
    }
}