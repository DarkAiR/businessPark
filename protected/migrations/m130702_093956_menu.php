<?php

class m130702_093956_menu extends CDbMigration
{
    public function up()
    {
        $this->execute("
CREATE TABLE `sitemenuitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentItemId` int(11) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(100) NOT NULL,
  `label` varchar(100) NOT NULL,
  `orderNum` int(10) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parentItemId` (`parentItemId`),
  KEY `orderNum` (`orderNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function down()
    {
        $this->dropTable("sitemenuitem");
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