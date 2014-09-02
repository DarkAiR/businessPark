<?php

class AdminResidentsController extends MAdminController
{
    public $modelName = 'Residents';
    public $modelHumanTitle = array('резидента', 'резидента', 'резидентов');


    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
                'imageWidth' => Residents::IMAGE_SMALL_W,
                //'imageHeight' => Residents::IMAGE_SMALL_H,
            ),
        );
    }

    public function getEditFormElements($model)
    {
        return array(
            'name' => array(
                'type' => 'textField',
            ),
            'desc' => array(
                'type' => 'ckEditor',
            ),
            'site' => array(
                'type' => 'textField',
            ),
            'phones' => array(
                'type' => 'textField',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_image',
                'removeImageFieldName' => '_removeImageFlag',
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
            $this->getImageColumn('image', 'getImageUrl()'),
            'name',
            'site',
            'phones',
            $this->getVisibleColumn(),
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
