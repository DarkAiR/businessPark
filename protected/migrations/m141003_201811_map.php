<?php

class m141003_201811_map extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `MapArea` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `cadastral`     int(11) NOT NULL UNIQUE         COMMENT 'Кадастровый номер',
                `square`        varchar(100) NOT NULL           COMMENT 'Площадь',
                `width`         int(11) NOT NULL DEFAULT 0      COMMENT 'Ширина',
                `height`        int(11) NOT NULL DEFAULT 0      COMMENT 'Высота',
                `resident`      varchar(100) NOT NULL           COMMENT 'Резидент',
                `busy`          tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Занят',
                PRIMARY KEY (`id`),
                KEY `visible` (`busy`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('MapArea');
    }
}