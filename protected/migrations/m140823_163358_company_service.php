<?php

class m140823_163358_company_service extends CDbMigration
{
    /*public function up()
    {
    }

    public function down()
    {
        echo "m140823_163358_company_service does not support migration down.\n";
        return false;
    }*/

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `CompanyService` (
                `id`        int(11) NOT NULL AUTO_INCREMENT,
                `type`      int(11) NOT NULL DEFAULT 1 COMMENT 'Тип услуги',
                `text`      text NOT NULL DEFAULT '' COMMENT 'Текст',
                `visible`   tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum`  int(10) NOT NULL DEFAULT '0',
                KEY `type` (`type`),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `CompanyService` (`orderNum`, `visible`, `type`, `text`)
            VALUES
            (1, 1, 1, 'Осуществляет комплексный инжиниринг при создании индустриального парка'),
            (2, 1, 1, 'Осуществляет функции технического Заказчика по сбору технических условий на проектирование подключений Резидентов к инженерным сетям'),
            (3, 1, 1, 'Обеспечивает техническую эксплуатацию инженерной инфраструктуры'),
            (4, 1, 1, 'Выполняет аварийное техническое обслуживание инженерной инфраструктуры'),
            (5, 1, 1, 'Осуществляет взаимодействие с сетевыми организациями по вопросам инженерного обеспечения проекта'),
            (6, 1, 1, 'Выполняет работы по содержанию и уборке дорог, вывозу снега, содержанию ландшафта'),
            (7, 1, 1, 'Осуществляет контрольно-пропускной режим на территории общего пользования'),
            (8, 1, 1, 'Осуществляет прогнозирование, контроль и учет коммунальных ресурсов проекта, содержание сетей наружного освещения'),
            (9, 1, 1, 'Организует вывоз ТБО с территории мест общего пользования'),
            (10, 1, 1, 'Обеспечивает содержание примыканий к автодорогам общего пользования'),

            (1, 1, 2, 'Техническая эксплуатации объектов (Facility management)'),
            (2, 1, 2, 'Услуги управления активом (Property management)'),
            (3, 1, 2, 'Услуги по разработке концепции освоения участка'),
            (4, 1, 2, 'Услуги управления проектами строительства «под ключ» на любом этапе проекта'),
            (5, 1, 2, 'Услуги инженерно-технического консалтинга'),
            (6, 1, 2, 'Консалтинг по вопросам будущего управления и эксплуатации'),
            (7, 1, 2, 'Технический аудит на этапе строительства'),
            (8, 1, 2, 'Технический аудит функционирующего объекта'),
            (9, 1, 2, 'Юридические услуги (сопровождение сделок, анализ рисков и т.д.)')
        ");
    }

    public function safeDown()
    {
        $this->dropTable('CompanyService');
    }
}