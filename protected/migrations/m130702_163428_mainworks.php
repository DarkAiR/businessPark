<?php

class m130702_163428_mainworks extends CDbMigration
{
    public function up()
    {
        $this->execute("
CREATE TABLE `mainworkitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(100) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `orderNum` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `orderNum` (`orderNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        $this->dropTable('mainworkitem');
        return true;
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}