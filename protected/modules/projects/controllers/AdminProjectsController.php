<?php

class AdminProjectsController extends MAdminController
{
    public $modelName = 'Projects';
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
        $sections = ProjectSections::model()->findAll();
        $sectArr = array();
        foreach ($sections as $sect)
        {
            $sectArr[$sect->id] = $sect->name;
        }

        return array(
            'sectionId' => array(
                'type' => 'dropdownlist',
                'data' => $sectArr,
                'empty' => 'Выбрать'
            ),
            'desc' => array(
                'type' => 'ckEditor',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
                'model' => $model,
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
            'sectionId',
            'image',
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
