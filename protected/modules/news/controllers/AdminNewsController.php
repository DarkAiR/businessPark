<?php

class AdminNewsController extends MAdminController
{
    public $modelName = 'News';
    public $modelHumanTitle = array('новость', 'новости', 'новостей');

    public function behaviors()
    {
        return array(
        );
    }

    public function getEditFormElements($model)
    {
        return array(
        	'title' => array(
        		'type' => 'textField',
        	),
            '_createTime' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'd-m-Y H:i'
                    ),
                ),
            ),
            'shortDesc' => array(
                'type' => 'ckEditor',
            ),
            'desc' => array(
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
            'id',
            '_createTime',
            'title',
            'newsLink',
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
