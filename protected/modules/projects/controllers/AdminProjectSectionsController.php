<?php

class AdminProjectSectionsController extends MAdminController
{
    public $modelName = 'ProjectSections';
    public $modelHumanTitle = array('рубрику', 'рубрики', 'рубрик');

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
            'name' => array(
                'type' => 'textField',
            ),
            '<hr/>',
            'title' => array(
                'type' => 'textField',
            ),
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
            'name',
            'title',
            'image',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
