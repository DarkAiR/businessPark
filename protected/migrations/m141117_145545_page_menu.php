<?php

class m141117_145545_page_menu extends CDbMigration
{
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `Menu`
                (`id`, `name`)
            VALUES
                (7, 'Верхнее меню на карте'),
                (8, 'Верхнее меню в инфраструктуре');
        ");

        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (7, 'Месторасположение г.Екатеринбург, Чкаловский район', 'http://maps.yandex.ru/?text=%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C%20%D0%A7%D0%BA%D0%B0%D0%BB%D0%BE%D0%B2%D1%81%D0%BA%D0%B8%D0%B9%20%D1%80%D0%B0%D0%B9%D0%BE%D0%BD&sll=60.69580199999998%2C56.75312099999265&sspn=0.013518%2C0.003613&ll=60.579594%2C56.719708&spn=0.054073%2C0.014465&z=15&l=sat%2Cskl%2Csat', 1, 1),
                (7, 'Панорама участков', 'panorams', 2, 1);
        ");
        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (8, 'Электричество',    'structure/#electricity', 1, 1),
                (8, 'Газ',              'structure/#gas',         2, 1),
                (8, 'Вода',             'structure/#water',       3, 1),
                (8, 'Водоотведение',    'structure/#sanitation',  4, 1),
                (8, 'Канализация',      'structure/#sewerage',    5, 1);
        ");
    }

    public function safeDown()
    {
        $this->execute("DELETE FROM `Menu` WHERE id IN (7,8)");
    }
}