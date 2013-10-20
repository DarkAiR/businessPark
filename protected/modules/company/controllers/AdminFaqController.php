<?php

class AdminFaqController extends MAdminController
{
    public $modelName = 'Faq';
    public $modelHumanTitle = array('элемент', 'элемента', 'элемента');


    public function getEditFormElements($model)
    {
        return array(
            'question' => array(
                'type' => 'textField',
            ),
            'answer' => array(
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
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'orderNum',
                'editable' => array(
                    'url' => $this->createUrl('update'),
                )
            ),
            'question',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
