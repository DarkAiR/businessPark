<?php

class AdminArticlesController extends MAdminController
{
    public $modelName = 'Articles';
    public $modelHumanTitle = array('статью', 'статьи', 'статей');
    public $allowedRoles = 'admin';

    public function getEditFormElements($model)
    {
        return array(
            'visible' => array(
                'type' => 'checkBox',
            ),
            'type' => array(
                'type' => 'dropdownlist',
                'data' => Articles::getTypeNames(),
                'htmlOptions' => array(
                    'data-placeholder' => Articles::TYPE_UNDER_CONSTRUCTION,
                ),
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
