<?php

class m130603_043202_create_projects_table extends CDbMigration
{
	public function up()
	{
        $transaction = $this->getDbConnection()->beginTransaction();
        try
        {
    		$this->createTable('projects', array(
                'id' => 'pk',
                'title' => 'string NOT NULL COMMENT "Заголовок"',
                'desc' => 'string NOT NULL COMMENT "Краткое описание для отображения на самом изображении"',
                'text' => 'text NOT NULL COMMENT "Описание (WYSIWYG)"',
                'link' => 'string COMMENT "Ссылка на сайт"',
                'image' => 'string NOT NULL COMMENT "Главная картинка"',
                'bigImage' => 'string COMMENT "Большая картинка"',
                'sectionId' => 'integer NOT NULL COMMENT "Раздел"'
                ),
                'ENGINE=InnoDB DEFAULT CHARSET=UTF8'
            );

            $this->createTable('projectSections', array(
                'id' => 'pk',
                'name' => 'string NOT NULL COMMENT "Название раздела"',
                ),
                'ENGINE=InnoDB DEFAULT CHARSET=UTF8'
            );

            $this->addForeignKey('projectToSections', 'projects', 'sectionId', 'projectSections', 'id' );

            $transaction->commit();
        }
        catch(Exception $e)
        {
            echo 'Exception: '.$e->getMessage().PHP_EOL;
            $transaction->rollback();
            return false;
        }
        return true;
	}

	public function down()
	{
        $transaction = $this->getDbConnection()->beginTransaction();
        try
        {
            $this->dropTable('projects');
            $this->dropTable('projectSections');
            $transaction->commit();
        }
        catch(Exception $e)
        {
            echo 'Exception: '.$e->getMessage().PHP_EOL;
            $transaction->rollback();
            return false;
        }
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