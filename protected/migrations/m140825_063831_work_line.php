<?php

class m140825_063831_work_line extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m140825_063831_work_line does not support migration down.\n";
		return false;
	}*/

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            CREATE TABLE IF NOT EXISTS `WorkLine` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `title`         varchar(100) NOT NULL           COMMENT 'Заголовок',
                `text`          text NOT NULL                   COMMENT 'Текст',
                `visible`       tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Показывать',
                `orderNum`      int(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`),
                KEY `visible` (`visible`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
	}

	public function safeDown()
	{
        $this->dropTable('WorkLine');
	}
}
