<?php

class AdminContentBlocksController extends MAdminController
{
    public $modelName = 'ContentBlocks';
    public $modelHumanTitle = array('контентный блок', 'контентные блоки', 'контентных блоков');
    public $allowedRoles = 'admin';

    public function getEditFormElements($model)
    {
        return array(
            'visible' => array(
                'type' => 'checkBox',
            ),
            'title' => array(
                'type' => 'ckEditor',
            ),
            'text' => array(
                'type' => 'ckEditor',
            ),
            'position' => array(
                'type' => 'dropdownlist',
                'data' => ContentBlocks::getPosNames(),
                'htmlOptions' => array(
                    'data-placeholder' => 3,
                ),
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            'title',
            $this->getSelectColumn('position', ContentBlocks::getPosNames()),
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
