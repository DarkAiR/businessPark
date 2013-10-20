<?php

class AdminVacancyController extends MAdminController
{
    public $modelName = 'Vacancy';
    public $modelHumanTitle = array('вакансию', 'вакансии', 'вакансий');

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
            $this->getImageColumn('image', 'getImageUrl()'),
            'title',
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
