<?php

class m130919_172152_persons extends CDbMigration
{
/*  public function up()
    {
    }

    public function down()
    {
        echo "m130919_172152_persons does not support migration down.\n";
        return false;
    }
*/
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Persons` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя',
                `position` varchar(255) NOT NULL DEFAULT '' COMMENT 'Должность',
                `photo` varchar(100) NOT NULL COMMENT 'Фотография',
                `photoBig` varchar(100) NOT NULL COMMENT 'Большая фотография',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `orderNum` (`orderNum`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Person2Project` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `personId` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Id человека',
                `projectId` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Id проекта',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Person2Project');
        $this->dropTable('Persons');
    }
}