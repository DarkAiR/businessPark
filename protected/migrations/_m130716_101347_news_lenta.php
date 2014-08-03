<?php

class m130716_101347_news_lenta extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m130716_101347_news_lenta does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `News` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `createTime` int(11) NOT NULL COMMENT 'Время создания',
                `title` varchar(100) NOT NULL COMMENT 'Заголовок',
                `desc` text NOT NULL COMMENT 'Текст',
                `sectionId` int(11) NOT NULL DEFAULT '0' COMMENT 'Раздел',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Показывать',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `sectionId` (`sectionId`),
                KEY `createTime` (`createTime`),
                KEY `orderNum` (`orderNum`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            ALTER TABLE `News` ADD COLUMN `shortDesc` text NOT NULL COMMENT 'Короткое описание' AFTER `title`;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('News');
    }
}