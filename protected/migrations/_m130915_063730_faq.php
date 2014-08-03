<?php

class m130915_063730_faq extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m130915_063730_faq does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Faq` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `question` text NOT NULL COMMENT 'Вопрос',
                `answer` text NOT NULL COMMENT 'Ответ',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0' COMMENT 'Порядок сортировки',
                PRIMARY KEY (`id`),
                KEY `orderNum` (`orderNum`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Faq');
    }
}