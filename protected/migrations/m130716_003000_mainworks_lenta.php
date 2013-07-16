<?php

class m130716_003000_mainworks_lenta extends CDbMigration
{
    /*public function up()
    {
        return true;
    }

    public function down()
    {
        return true;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `projectSections` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(100) NOT NULL COMMENT 'Заголовок для отображения в меню',
                `title` varchar(100) NOT NULL COMMENT 'Заголовок',
                `desc` text NOT NULL COMMENT 'Основной текст',
                `image` varchar(100) NOT NULL COMMENT 'Картинка',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `orderNum` (`orderNum`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT 'Рубрики';
        ");

        $this->execute("
            CREATE TABLE IF NOT EXISTS `projects` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `desc` varchar(255) NOT NULL COMMENT 'Краткое описание',
                `image` varchar(100) NOT NULL COMMENT 'Картинка',
                `sectionId` int(11) NOT NULL DEFAULT '0' COMMENT 'Раздел',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `sectionId` (`sectionId`),
                KEY `orderNum` (`orderNum`),
                CONSTRAINT `fk_sectionId` FOREIGN KEY (`sectionId`) REFERENCES projectSections(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            ALTER TABLE `projects` ADD COLUMN `createTime` int(11) NOT NULL COMMENT 'Время создания' AFTER `id`;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('projects');
        $this->dropTable('projectSections');
    }
}