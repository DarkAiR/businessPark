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
                'data' => $model->getTypeNames(),
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
        $attributes = array(
            'id',
            'title',
            'type',
            'visible',
            $buttons
        );

        return $attributes;
    }
}
