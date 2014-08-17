<?php

class m140801_055412_menu extends CDbMigration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Menu` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `visible` tinyint(1) NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS `MenuItem` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `menuId` int(11) NOT NULL DEFAULT '0',
                `parentItemId` int(11) NOT NULL DEFAULT '0',
                `visible` tinyint(1) NOT NULL DEFAULT '1',
                `name` varchar(100) NOT NULL,
                `link` TEXT NOT NULL,
                `orderNum` int(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `parentItemId` (`parentItemId`),
                KEY `orderNum` (`orderNum`),
                CONSTRAINT `fk_menuId` FOREIGN KEY (`menuId`) REFERENCES menu(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `Menu`
                (`id`, `name`)
            VALUES
                (1, 'Главное меню'),
                (2, 'Второе меню на главной странице');
        ");

        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (1, 'Генеральный план', 'general-plan', 1, 1),
                (1, 'Инфраструктура', 'structure', 2, 1),
                (1, 'Управляющая компания', 'company', 3, 0),
                (1, 'От слов к делу', 'department', 4, 0),
                (1, 'Новости', 'news', 5, 0),
                
                (2, 'Контактная информация', 'contact-info', 1, 1),
                (2, 'О проекте', 'about', 2, 0);
        ");
    }

    public function safeDown()
    {
        $this->dropTable('MenuItem');
        $this->dropTable("Menu");
    }
}