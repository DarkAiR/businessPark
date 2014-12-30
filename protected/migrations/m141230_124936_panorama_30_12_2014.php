<?php

class m141230_124936_panorama_30_12_2014 extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `Panorama`
                (`createDate`, `swf`, `mov`)
            VALUES
                ('2014-12-30', '4_1', '4_1'),
                ('2014-12-30', '4_2', '4_2');
        ");
    }

    public function safeDown()
    {
        $this->execute("
            DELETE FROM `Panorama` WHERE createDate = '2014-12-30';
        ");
    }
}