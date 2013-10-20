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
            '<h1>Маленькая работа</h1>',
            'visible' => array(
                'type' => 'checkBox',
            ),
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

            '<hr/>',
            '<h1>Большая работа</h1>',

            'showImageBig' => array(
                'type' => 'checkBox',
            ),
            '_imageBig' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_imageBig',
                'removeImageFieldName' => '_removeImageBigFlag',
            ),
            'titleBig' => array(
                'type' => 'textField',
            ),
            'descBig' => array(
                'type' => 'ckEditor',
            ),

            '<hr/>',
            '<h1>Внутри работы</h1>',

            'publishTime' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'dd.mm.yyyy'
                    ),
                ),
            ),
            'title' => array(
                'type' => 'textField',
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
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name' => 'orderNum',
                'editable' => array(
                    'url' => $this->createUrl('update'),
                )
            ),
            'publishTime',
            'sectionId',
            $this->getImageColumn('image', 'getImageUrl()'),
            'title',
            'showImageBig',
            'projectLink',
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
