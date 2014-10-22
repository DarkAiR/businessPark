<?php

class m140927_052311_left_menu extends CDbMigration
{
    public function safeUp()
    {
    	$this->execute("
    		ALTER TABLE `MenuItem` 
			DROP FOREIGN KEY `fk_menuId`;
		");
		$this->execute("
			ALTER TABLE `MenuItem` 
			ADD CONSTRAINT `fk_menuId`
  				FOREIGN KEY (`menuId`)
  				REFERENCES `Menu` (`id`)
				ON DELETE CASCADE
  				ON UPDATE CASCADE;
  		");

        $this->execute("
            INSERT INTO `Menu`
                (`id`, `name`)
            VALUES
                (4, 'Боковое меню на главной'),
                (5, 'Боковое меню в новостях'),
                (6, 'Боковое меню в контактах');
        ");

        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (4, 'Презентация', 			'presentation', 1, 1),
                (4, 'Панорама участков', 	'panorams', 	2, 1),
                (4, 'Резиденты парка', 		'residents', 	3, 1);
        ");
        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (5, 'Презентация', 			'presentation', 1, 1),
                (5, 'Панорама участков', 	'panorams', 	2, 1),
                (5, 'Резиденты парка', 		'residents', 	3, 1);
        ");
        $this->execute("
            INSERT INTO `MenuItem`
                (`menuId`, `name`, `link`, `orderNum`, `visible`)
            VALUES
                (6, 'Презентация', 			'presentation', 1, 1),
                (6, 'Панорама участков', 	'panorams', 	2, 1),
                (6, 'Резиденты парка', 		'residents', 	3, 1);
        ");
    }

    public function safeDown()
    {
		$this->execute("DELETE FROM `Menu` WHERE id IN (4,5,6)");
    }
}