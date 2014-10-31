<?php

class m141027_184247_area_price extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('MapArea', 'price', 'FLOAT not null DEFAULT 0 COMMENT "Стоимость"');
        $this->addColumn('MapArea', 'priceType', 'INT(4) not null DEFAULT 0 COMMENT "Тип исчисления"');
    }

    public function safeDown()
    {
        $this->dropColumn('MapArea', 'price');
        $this->dropColumn('MapArea', 'priceType');
    }
}
