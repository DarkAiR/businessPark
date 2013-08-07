<?php

class AdminProjectsOwnController extends MAdminController
{
    public $modelName = 'ProjectsOwn';
    public $modelHumanTitle = array('проект', 'проекта', 'проектов');

    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
            )
        );
    }

    public function getEditFormElements($model)
    {
        return array(
            'desc' => array(
                'type' => 'textArea',
            ),
            'link' => array(
            	'type' => 'textField',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
            ),
            'type' => array(
                'type' => 'dropdownlist',
                'data' => ProjectsOwn::getTypes(),
                'empty' => 'Выбрать'
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
            'link',
            'image',
            'type',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBeforeSave($model);
        parent::beforeSave($model);
    }
}
