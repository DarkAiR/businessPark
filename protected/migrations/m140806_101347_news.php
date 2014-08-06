<?php

class m140806_101347_news extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m140806_101347_news does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `News` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `createTime`    int(11) NOT NULL                COMMENT 'Время создания',
                `title`         varchar(100) NOT NULL           COMMENT 'Заголовок',
                `shortDesc`     text NOT NULL                   COMMENT 'Короткое описание',
                `desc`          text NOT NULL                   COMMENT 'Текст',
                `image`         varchar(100) NOT NULL           COMMENT 'Картинка',
                `imageBig`      VARCHAR(100) NOT NULL           COMMENT 'Большая картинка',
                `onMain`        tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Показывать на главной',
                `visible`       tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Показывать',
                PRIMARY KEY (`id`),
                KEY `createTime` (`createTime`),
                KEY `onMain` (`onMain`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('News');
    }
}