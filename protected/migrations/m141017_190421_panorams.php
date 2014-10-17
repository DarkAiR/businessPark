<?php

class m141017_190421_panorams extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Panorama` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `createDate`    DATE NOT NULL                   COMMENT 'Дата',
                `swf`           varchar(255) NOT NULL           COMMENT 'Файл swf',
                `mov`           varchar(255) NOT NULL           COMMENT 'Файл mov',
                `visible`       tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Показывать',
                PRIMARY KEY (`id`),
                KEY `visible` (`visible`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `Panorama`
                (`createDate`, `swf`, `mov`)
            VALUES
                ('2014-08-01', '1_1', ''),
                ('2014-08-01', '1_2', ''),
                ('2014-10-01', '2_1', '2_1'),
                ('2014-10-01', '2_2', '2_2');
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Panorama');
    }
}