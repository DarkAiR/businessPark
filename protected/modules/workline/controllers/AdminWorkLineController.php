<?php

class AdminWorkLineController extends MAdminController
{
    public $modelName = 'WorkLine';
    public $modelHumanTitle = array('шаг', 'шага', 'шагов');

    public function getEditFormElements($model)
    {
        return array(
            'orderNum' => array(
                'type' => 'textField',
            ),
            'title' => array(
                'type' => 'textField',
            ),
            'text' => array(
                'type' => 'ckEditor',
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
            'title',
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
