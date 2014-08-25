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
                `id` int(11) NOT NULL,
                `type` int(11) NOT NULL DEFAULT 0 COMMENT 'Тип услуги',
                `text` text NOT NULL DEFAULT '' COMMENT 'Текст',
                `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Видимость',
                `orderNum` int(10) NOT NULL DEFAULT '0',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('CompanyService');
    }
}

class AdminCompanyServiceController extends MAdminController
{
    public $modelName = 'CompanyService';
    public $modelHumanTitle = array('услугу', 'услуг', 'услуг');

    public function getEditFormElements($model)
    {
        return array(
            'type' => array(
                'type' => 'dropdownlist',
                'data' => CompanyService::getTypeNames(),
                'empty' => CompanyService::TYPE_BASE,
            ),
            'text' => array(
                'type' => 'textArea',
                'htmlOptions' => array(
                    'rows' => 10,
                ),
            ),
            'visible' => array(
                'type' => 'checkBox',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            $this->getOrderColumn(),
            $this->getSelectColumn('type', CompanyService::getTypeNames()),
            'text',
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
