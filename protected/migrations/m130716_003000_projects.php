<?php

class m130716_003000_projects extends CDbMigration
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
            CREATE TABLE IF NOT EXISTS `ProjectSections` (
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
            CREATE TABLE IF NOT EXISTS `Projects` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `createTime` int(11) NOT NULL COMMENT 'Время создания',
                `desc` varchar(255) NOT NULL COMMENT 'Краткое описание',
                `image` varchar(100) NOT NULL COMMENT 'Картинка',
                `imageBig` VARCHAR(100) NOT NULL COMMENT 'Большая картинка',
                `showImageBig` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Показывать большую картинку',
                `sectionId` int(11) NOT NULL DEFAULT '0' COMMENT 'Раздел',

                `title` varchar(255) NOT NULL COMMENT 'Заголовок',
                `goal` varchar(255) NOT NULL COMMENT 'Задача',
                `publishTime` int(11) NOT NULL COMMENT 'Время выпуска',
                `link` varchar(100) NOT NULL COMMENT 'Ссылка',
                `linkIcon` varchar(100) NOT NULL COMMENT 'Иконка ссылки',
                `resultText` text NOT NULL COMMENT 'Текст результата',
                `processText` text NOT NULL COMMENT 'Текст процесса',

                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `sectionId` (`sectionId`),
                KEY `orderNum` (`orderNum`),
                CONSTRAINT `fk_sectionId` FOREIGN KEY (`sectionId`) REFERENCES projectSections(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Projects');
        $this->dropTable('ProjectSections');
    }
}