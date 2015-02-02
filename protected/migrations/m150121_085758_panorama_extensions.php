<?php

class m150121_085758_panorama_extensions extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            UPDATE `Panorama` SET `swf` = concat(`swf`,'.swf') WHERE `swf` != '';
        ");
        $this->execute("
            UPDATE `Panorama` SET `mov` = concat(`mov`,'.mov') WHERE `mov` != '';
        ");
    }

    public function safeDown()
    {
        $this->execute("
            UPDATE `Panorama` SET `swf` = REPLACE(`swf`,'.swf','') WHERE RIGHT(`swf`,4)='.swf';
        ");
        $this->execute("
            UPDATE `Panorama` SET `mov` = REPLACE(`mov`,'.mov','') WHERE RIGHT(`mov`,4)='.mov';
        ");
    }
}
