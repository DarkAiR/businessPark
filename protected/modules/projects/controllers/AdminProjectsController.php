<?php

class AdminProjectsController extends MAdminController
{
    public $modelName = 'Projects';
    public $modelHumanTitle = array('работу', 'работы', 'работ');

    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
            ),
            'imageBigBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'imageBig',
                'innerImageField' => '_imageBig',
                'innerRemoveBtnField' => '_removeImageBigFlag',
            ),
            'linkIconBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'linkIcon',
                'innerImageField' => '_linkIcon',
                'innerRemoveBtnField' => '_removeLinkIconFlag',
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
            '<h1>Описание работы для списка</h1>',
            'visible' => array(
                'type' => 'checkBox',
            ),
            'sectionId' => array(
                'type' => 'dropdownlist',
                'data' => $sectArr,
                'empty' => 'Выбрать'
            ),
            'title' => array(
                'type' => 'textField',
            ),
            'desc' => array(
                'type' => 'ckEditor',
            ),
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_image',
                'removeImageFieldName' => '_removeImageFlag',
            ),
            '_imageBig' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_imageBig',
                'removeImageFieldName' => '_removeImageBigFlag',
            ),
            'showImageBig' => array(
                'type' => 'checkBox',
            ),

            '<hr/>',
            '<h1>Описание работы внутренней страницы</h1>',

            'publishTime' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'dd.mm.yyyy'
                    ),
                ),
            ),
            'goal' => array(
                'type' => 'textArea',
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
            'publishTime',
            'sectionId',
            'title',
            'showImageBig',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        $this->imageBigBehavior->imageBeforeSave($model, $model->imageBigBehavior->getStorePath());
        $this->linkIconBehavior->imageBeforeSave($model, $model->linkIconBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
