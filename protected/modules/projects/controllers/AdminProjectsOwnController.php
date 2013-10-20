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
                'type' => 'ckEditor',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
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
            $this->getImageColumn('image', 'getImageUrl()'),
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
