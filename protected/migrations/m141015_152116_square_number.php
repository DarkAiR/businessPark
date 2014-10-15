<?php

class m141015_152116_square_number extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->alterColumn('MapArea', 'square', 'int(11) not null COMMENT "Площадь"');
    }

    public function safeDown()
    {
        $this->alterColumn('MapArea', 'square', 'varchar(100) not null COMMENT "Площадь"');
    }
}
