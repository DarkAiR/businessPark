<?php

class AdminProjectSectionsController extends MAdminController
{
    public $modelName = 'ProjectSections';
    public $modelHumanTitle = array('рубрику', 'рубрики', 'рубрик');

    public function getEditFormElements($model)
    {
        return array(
            'name' => array(
                'type' => 'textField',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'name',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
