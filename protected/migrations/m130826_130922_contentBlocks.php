<?php

class m130826_130922_contentBlocks extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m130826_130922_contentBlocks does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `contentBlocks` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` text NOT NULL COMMENT 'Заголовок',
                `text` text NOT NULL COMMENT 'Текст',
                `position` int(11) NOT NULL DEFAULT '0' COMMENT 'Место размещения',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                PRIMARY KEY (`id`),
                KEY `position` (`position`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('contentBlocks');
    }
}