<?php

class m130716_113820_own_projects extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m130716_113820_own_projects does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `projectsOwn` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `desc` varchar(255) NOT NULL COMMENT 'Краткое описание',
                `link` varchar(100) NOT NULL COMMENT 'Ссылка',
                `image` varchar(100) NOT NULL COMMENT 'Картинка',
                `type` int(11) NOT NULL DEFAULT '0' COMMENT 'Тип',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `orderNum` (`orderNum`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('projectsOwn');
    }
}