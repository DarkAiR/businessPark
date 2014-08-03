<?php

class AdminPersonsController extends MAdminController
{
    public $modelName = 'Persons';
    public $modelHumanTitle = array('сотрудника', 'сотрудника', 'сотрудников');


    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'photo',
                'innerImageField' => '_photo',
                'innerRemoveBtnField' => '_removePhotoFlag',
            ),
            'imageBigBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'photoBig',
                'innerImageField' => '_photoBig',
                'innerRemoveBtnField' => '_removePhotoBigFlag',
            ),
        );
    }

    public function getEditFormElements($model)
    {
        return array(
            'visible' => array(
                'type' => 'checkBox',
            ),
            'showInCommand' => array(
                'type' => 'checkBox',
            ),
            'name' => array(
                'type' => 'textField',
            ),
            'position' => array(
                'type' => 'textField',
            ),
            '_photo' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_photo',
                'removeImageFieldName' => '_removePhotoFlag',
            ),
            '_photoBig' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_photoBig',
                'removeImageFieldName' => '_removePhotoBigFlag',
            ),
            'projects' => array(
                'type' => 'select2',
                'htmlOptions' => array(
                    'data' => CHtml::listData(Projects::model()->orderDefault()->findAll(), 'id', 'title'),
                    'multiple' => true,
                    'class' => 'input-xlarge',
                ),
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            $this->getImageColumn('photoBig', 'getPhotoBigUrl()'),
            $this->getImageColumn('photo', 'getPhotoUrl()'),
            'name',
            'position',
            $this->getBooleanColumn('showInCommand', 'icon-user'),
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        $this->imageBigBehavior->imageBeforeSave($model, $model->imageBigBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
