<?php

class AdminContentBlocksController extends MAdminController
{
    public $modelName = 'ContentBlocks';
    public $modelHumanTitle = array('контентный блок', 'контентные блоки', 'контентных блоков');

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
                'data' => $model->getPosNames(),
                'empty' => 'Выбрать'
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            'title',
            'position',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
