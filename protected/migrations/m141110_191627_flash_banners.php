<?php

class m141110_191627_flash_banners extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('Banners', 'flash', "varchar(100) NOT NULL COMMENT 'Флеш'");
    }

    public function safeDown()
    {
        $this->dropColumn('Banners', 'flash');
    }
}