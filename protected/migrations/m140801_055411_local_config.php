<?php

class m140801_055411_local_config extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m140801_055411_local_config does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `localconfig` (
                `id`          varchar(255) NOT NULL DEFAULT '',
                `value`       text NOT NULL,
                `module`      varchar(255) DEFAULT NULL,
                `description` text,
                `example`     text NOT NULL,
                `type`        ENUM('bool', 'int', 'fixedarray', 'dynamicarray', 'string', 'multilinestring', 'file', 'twopowarray'),
                PRIMARY KEY (`id`),
                KEY `module` (`module`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );
        $this->execute('
            INSERT INTO localconfig
            (`id`, `value`, `module`, `description`, `example`, `type`)
            VALUES
            ("title", "Земельные участки\nпромышленного назначения", "", "Заголовок сайта", "Текст", "multilinestring"),
            ("titleDesc", "Месторасположение г.Екатеринбург Чкаловский район", "", "Подпись под заголовком", "Текст", "multilinestring")
        ');
    }

    public function safeDown()
    {
        $this->dropTable('localconfig');
    }
}
