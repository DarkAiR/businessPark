<?php

class m140902_194658_residents extends CDbMigration
{
/*    public function up()
    {
    }

    public function down()
    {
        echo "m140902_194658_residents does not support migration down.\n";
        return false;
    }
*/
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Residents` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `name`          varchar(100) NOT NULL           COMMENT 'Название',
                `desc`          text NOT NULL                   COMMENT 'Текст',
                `site`          varchar(255) NOT NULL           COMMENT 'Сайт',
                `phones`        text NOT NULL                   COMMENT 'Телефоны',
                `image`         varchar(100) NOT NULL           COMMENT 'Картинка',
                `visible`       tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Показывать',
                `orderNum`      int(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `visible` (`visible`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Residents');
    }
}
