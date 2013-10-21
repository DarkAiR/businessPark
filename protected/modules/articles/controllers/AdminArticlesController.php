<?php

class AdminArticlesController extends MAdminController
{
    public $modelName = 'Articles';
    public $modelHumanTitle = array('статью', 'статьи', 'статей');

    public function getEditFormElements($model)
    {
        return array(
            'visible' => array(
                'type' => 'checkBox',
            ),
            'type' => array(
                'type' => 'dropdownlist',
                'data' => Articles::getTypeNames(),
                'empty' => Articles::TYPE_CUSTOM,
            ),
            'title' => array(
                'type' => 'textField',
            ),
            'text' => array(
                'type' => 'ckEditor',
            ),
        );
    }

    public function getTableColumns()
    {
        $buttons = $this->getButtonsColumn();
        $buttons['deleteButtonOptions'] = array(
            'visible' => '!$data->visible;'
        );
//echo '<pre>';
//var_dump( ContentBlocks::getPosNames() );
//var_dump( Articles::getTypeNames() );
//die;
        $attributes = array(
            'id',
            'title',
            'type',
            $this->getVisibleColumn(),
            $buttons
        );

        return $attributes;
    }
}
