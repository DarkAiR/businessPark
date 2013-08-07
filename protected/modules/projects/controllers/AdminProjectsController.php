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
            ),
            'linkIconBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'linkIcon',
                'innerImageField' => '_linkIcon',
                'innerRemoveBtnField' => '_removeLinkIconFlag',            )
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
                'uploadedFileFieldName' => '_image',
                'removeImageFieldName' => '_removeImageFlag',
            ),
            'visible' => array(
                'type' => 'checkBox',
            ),

            '<hr/>',

            'title' => array(
                'type' => 'textArea',
            ),
            'goal' => array(
                'type' => 'textArea',
            ),
            'publishTime' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'dd.mm.yyyy'
                    ),
                ),
            ),
            'link' => array(
                'type' => 'textField',
            ),
            '_linkIcon' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_linkIcon',
                'removeImageFieldName' => '_removeLinkIconFlag',
            ),
            'resultText' => array(
                'type' => 'ckEditor',
            ),
            'processText' => array(
                'type' => 'ckEditor',
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
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        $this->linkIconBehavior->imageBeforeSave($model, $model->linkIconBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
