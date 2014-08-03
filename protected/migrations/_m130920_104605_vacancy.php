<?php

class m130920_104605_vacancy extends CDbMigration
{
/*  public function up()
    {
    }

    public function down()
    {
        echo "m130920_104605_vacancy does not support migration down.\n";
        return false;
    }*/

    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Vacancy` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Название должности',
                `text` text NOT NULL DEFAULT '' COMMENT 'Описание',
                `image` varchar(100) NOT NULL COMMENT 'Изображение для списка',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `orderNum` (`orderNum`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Vacancy');
    }
}