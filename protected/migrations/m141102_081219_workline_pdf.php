<?php

class m141102_081219_workline_pdf extends CDbMigration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `WorkLinePdf` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `data`          text NOT NULL COMMENT 'Данные в JSON',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");


        $data = json_encode(array(
        ));
        $this->execute("
            INSERT INTO `WorkLinePdf` (`id`, `data`) VALUES (1, '".$data."');
        ");
    }

    public function safeDown()
    {
        $this->dropTable('WorkLinePdf');
    }
}