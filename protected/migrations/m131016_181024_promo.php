<?php

class m131016_181024_promo extends CDbMigration
{
/*  public function up()
    {
    }

    public function down()
    {
        echo "m130920_104605_vacancy does not support migration down.\n";
        return false;
    }*/

    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Promo` (
                `id` int(11) NOT NULL,
                `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Заголовок',
                `motto` varchar(255) NOT NULL DEFAULT '' COMMENT 'Девиз',
                `text` text NOT NULL DEFAULT '' COMMENT 'Описание',
                `image` varchar(100) NOT NULL COMMENT 'Изображение для списка',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->execute("
            INSERT INTO `Promo`
            (`id`, `title`,`motto`,`text`,`visible`)
            VALUES
            (1, 'Наша история начинается...', 'Кто с нами?', 'Войдите в историю вместе с нами', 1)
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Promo');
    }
}