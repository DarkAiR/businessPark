<?php

class AdminMapInfrastructureController extends MAdminController
{
    public $modelName = 'MapInfrastructure';
    public $modelHumanTitle = array('участок', 'участка', 'участков');
    public $allowedActions = 'edit';


    public function getEditFormElements($model)
    {
        return array(
            'desc' => array(
                'type' => 'textArea',
                'htmlOptions' => array(
                    'rows' => 10,
                    'style' => 'width:500px'
                ),
            ),
            'square' => array(
                'type' => 'textField',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            array(
                'class' => 'ext.widgets.SelectColumn',
                'name' => 'type',
                'data' => MapInfrastructure::getTypes(),
                'value' => '$data->type'
            ),
            'number',
            'desc',
            'square',
            $this->getButtonsColumn(),
        );
        return $attributes;
    }
}
