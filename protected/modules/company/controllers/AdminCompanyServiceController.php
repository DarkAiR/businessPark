<?php

class AdminCompanyServiceController extends MAdminController
{
    public $modelName = 'CompanyService';
    public $modelHumanTitle = array('услугу', 'услуг', 'услуг');
    public $allowedRoles = 'admin';

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
