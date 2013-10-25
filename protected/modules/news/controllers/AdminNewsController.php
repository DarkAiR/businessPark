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
            'createTimeDate' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'dd.mm.yyyy'
                    ),
                ),
            ),
            'createTimeTime' => array(
                'type' => 'timepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'showMeridian' => false,
                        'defaultTime' => 'value',
                    ),
                ),
            ),
            //'createTimeTime' => array(
            //    'type' => 'textField',
            //),
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
