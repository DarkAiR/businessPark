<?php

class m130702_093956_menu extends CDbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `menu` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `visible` tinyint(1) NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            CREATE TABLE IF NOT EXISTS `menuitem` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `menuId` int(11) NOT NULL DEFAULT '0',
                `parentItemId` int(11) NOT NULL DEFAULT '0',
                `visible` tinyint(1) NOT NULL DEFAULT '1',
                `name` varchar(100) NOT NULL,
                `link` varchar(100) NOT NULL,
                `orderNum` int(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `parentItemId` (`parentItemId`),
                KEY `orderNum` (`orderNum`),
                CONSTRAINT `fk_menuId` FOREIGN KEY (`menuId`) REFERENCES menu(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `menu` (`name`,`visible`) VALUES ('Главное меню',1);
        ");
    }

    public function down()
    {
        $this->dropTable('menuitem');
        $this->dropTable("menu");
        return true;
    }
}