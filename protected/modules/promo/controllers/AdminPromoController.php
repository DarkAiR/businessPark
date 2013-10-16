<?php

class AdminPromoController extends MAdminController
{
    public $modelName = 'Promo';
    public $modelHumanTitle = array('промо', 'промо', 'промо');
    public $allowedActions = 'edit';
    public $defaultAction = 'edit';


    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
            ),
        );
    }

    public function getEditFormElements($model)
    {
        return array(
            'visible' => array(
                'type' => 'checkBox',
            ),
            'title' => array(
                'type' => 'textField',
            ),
            'motto' => array(
                'type' => 'textField',
            ),
            'text' => array(
                'type' => 'ckEditor',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_image',
                'removeImageFieldName' => '_removeImageFlag',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            'title',
            'motto',
            'image',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function actionIndex()
    {
        $this->actionEdit();
    }

    public function actionAdd()
    {
        $this->actionEdit();
    }

    public function actionEdit($createNew = false)
    {
        $_GET['id'] = Promo::DEFAULT_ID;
        parent::actionEdit($createNew);
    }

    public function beforeSave($model)
    {
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
