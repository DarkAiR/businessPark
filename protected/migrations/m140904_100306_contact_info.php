<?php

class m140904_100306_contact_info extends CDbMigration
{
    public function safeUp()
    {
        $this->execute('
            INSERT INTO localconfig
                (`id`, `value`, `module`, `description`, `example`, `type`)
            VALUES
                ("mainPhones", "[\"+7(343) 263-71-70\"]", "contact-info", "Телефоны управляющей компании", "[\"+7(343) 263-71-70\"]", "dynamicarray"),
                ("salesPhone", "[\"+7(343) 344-99-99\"]", "contact-info", "Телефоны отдела продаж", "[\"+7(343) 344-99-99\"]", "dynamicarray"),
                ("email", "uk@p-b-p.ru", "contact-info", "Почта", "uk@p-b-p.ru", "string"),
                ("city", "г. Екатеринбург", "contact-info", "Город", "г. Екатеринбург", "string"),
                ("address", "ул. Народной Воли, 19а", "contact-info", "Адрес", "ул. Народной Воли, 19а", "string"),
                ("office", "офис 709", "contact-info", "Офис", "офис 709", "string")
        ');
    }

    public function safeDown()
    {
        $this->execute("
            DELETE FROM localconfig WHERE id IN ('mainPhones', 'salesPhone', 'email', 'city', 'address', 'office')
        ");
    }
}

