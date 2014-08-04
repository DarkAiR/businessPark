<?php

class m140802_051504_articles extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m140802_051504_articles does not support migration down.\n";
        return false;
    }*/


    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Articles` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `type` int(11) NOT NULL DEFAULT 0 COMMENT 'Тип статьи, см. Articles',
                `title` text NOT NULL DEFAULT '' COMMENT 'Заголовок',
                `text` text NOT NULL DEFAULT '' COMMENT 'Текст',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                PRIMARY KEY (`id`),
                KEY `type` (`type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `Articles` (`type`,`title`,`text`) VALUES ('".Articles::TYPE_UNDER_CONSTRUCTION."','В разработке','Раздел находится в разработке');
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Articles');
    }
}