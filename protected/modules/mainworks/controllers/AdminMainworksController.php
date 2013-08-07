<?php

class AdminMainworksController extends MAdminController
{
    public $modelName = 'MainWorkItem';
    public $modelHumanTitle = array('изображение', 'изображения', 'изображений');

    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
            )
        );
    }

    /**
     * @param User $model
     * @return array
     */
    public function getEditFormElements($model)
    {
        return array(
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
            ),
            'title' => array(
                'type' => 'textField',
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
            'title',
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
