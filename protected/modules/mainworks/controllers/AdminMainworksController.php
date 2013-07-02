<?php

class AdminMainworksController extends MAdminController
{
    public $modelName = 'MainWorkItem';
    public $modelHumanTitle = array('изображение', 'изображения', 'изображений');

    /**
     * @param User $model
     * @return array
     */
    public function getEditFormElements($model)
    {
        return array(
            array(
                'class' => 'ext.ImageFileRowWidget',
                'model' => $model,
                'attribute' => 'image',
            ),
            'title' => array(
                'type' => 'textField',
            ),
            /*'desc' => array(
                'type' => 'textField',
            ),*/
            'desc' => array(
                'class' => 'ext.editMe.widgets.ExtEditMe',
                'model' => $model,
                'attribute' => 'desc',
                'width' => 500,
                'toolbar' => 'mini',
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
        if ($model->_removeImageFlag)
        {
            // removing file
            // set attribute to null
            unlink( $model->getStorePath().$model->image );
            $model->image = null;
        }
        $model->_image = CUploadedFile::getInstance($model, '_image');
        if ($model->validate() && !empty($model->_image))
        {
            // saving file from CUploadFile instance $model->_image
            $model->_image->saveAs( $model->getStorePath().$model->_image->name );
            $model->image = $model->_image->name;
        }

        parent::beforeSave($model);
    }
}
