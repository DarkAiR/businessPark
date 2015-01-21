<?php

class AdminPanoramsController extends MAdminController
{
    public $modelName = 'Panorama';
    public $modelHumanTitle = array('панораму', 'панорамы', 'панорам');

    public function behaviors()
    {
        return array(
            'videoBehavior' => array(
                'class' => 'application.behaviors.FlashControllerBehavior',
                'flashField' => 'mov',
                'innerField' => '_mov',
                'innerRemoveBtnField' => '_removeMov'
            ),
            'flashBehavior' => array(
                'class' => 'application.behaviors.FlashControllerBehavior',
                'flashField' => 'swf',
                'innerField' => '_swf',
                'innerRemoveBtnField' => '_removeSwf'
            ),
        );
    }

    public function getEditFormElements($model)
    {
        return array(
            'createDate' => array(
                'type' => 'datepicker',
                'htmlOptions' => array(
                    'options' => array(
                        'format' => 'yyyy-mm-dd'
                    ),
                ),
            ),            
            '_swf' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_swf',
                'removeImageFieldName' => '_removeSwf',
            ),
            '_mov' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_mov',
                'removeImageFieldName' => '_removeMov',
            ),
            'visible' => array(
                'type' => 'checkBox',
            ),
        );
    }

    public function getTableColumns()
    {
        $attributes = array(
            'createDate',
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->videoBehavior->flashBeforeSave($model, $model->flashBehavior->getStorePath());
        $this->flashBehavior->flashBeforeSave($model, $model->flashBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
