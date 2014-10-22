<?php

class m141019_193550_map_infrastructure extends CDbMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `MapInfrastructure` (
                `id`            int(11) NOT NULL AUTO_INCREMENT,
                `type`          int(11) NOT NULL DEFAULT 1          COMMENT 'Тип',
                `number`        varchar(100) NOT NULL DEFAULT ''    COMMENT 'Номер',
                `square`        varchar(100) NOT NULL DEFAULT '0'   COMMENT 'Площадь',
                `desc`          varchar(100) NOT NULL               COMMENT 'Описание',
                PRIMARY KEY (`id`),
                KEY `type` (`type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `MapInfrastructure`
                (`type`, `number`, `desc`)
            VALUES
                ('1', '1', 'КТПН №1 10/0.4 кВ'),
                ('1', '2', 'КТПН №2 10/0.4 кВ'),
                ('1', '3', 'КТПН №3 10/0.4 кВ'),
                ('1', '4', 'КТПН №4 10/0.4 кВ'),
                ('1', '5', 'КТПН №5 10/0.4 кВ'),
                ('1', '6', 'КТПН №6 10/0.4 кВ'),
                ('1', '7', 'КТПН №7 10/0.4 кВ'),
                ('1', '8', 'КТПН №8 10/0.4 кВ'),
                ('1', '9', 'КТПН №9 10/0.4 кВ'),
                ('1', '10', 'КТПН №10 10/0.4 кВ'),
                ('1', '11', 'КТПН №11 10/0.4 кВ'),
                ('1', '12', 'КТПН №12 10/0.4 кВ'),
                ('1', '02', 'Распределительная подстанция (РП) №1 10 кВ\nРаспределительная подстанция (РП) №2 10 кВ'),
                ('1', '03', 'Подстанция (ПС) 110/10 кВ'),

                ('2', '1', 'Очистные сооружения 1-ой очереди'),
                ('2', '2', 'Очистные сооружения 2-ой очереди'),

                ('3', '1', 'ГРПШ 1-ой очереди'),
                ('3', '2', 'ГРПШ 2-ой очереди'),

                ('4', '1', 'Водозаборный узел'),

                ('5', '1', 'Канализационная насосная станция (КНС)');
        ");
    }

    public function safeDown()
    {
        $this->dropTable('MapInfrastructure');
    }
}