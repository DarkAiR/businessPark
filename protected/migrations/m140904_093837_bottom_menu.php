<?php

class m140904_093837_bottom_menu extends CDbMigration
{
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
        $this->execute("
            INSERT INTO `Menu`
                (`id`, `name`)
            VALUES
                (3, 'Меню в подвале');
        ");

        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (3, 'Резиденты', 'residents', 1, 1),
                (3, 'Документы', 'documents', 2, 1);
        ");
    }

    public function safeDown()
    {
        $this->execute("DELETE FROM `MenuItem` WHERE menuId=3");
        $this->execute("DELETE FROM `Menu` WHERE id=3");
    }
}