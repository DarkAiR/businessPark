<?php

class ImageControllerBehavior extends CBehavior
{
    public $imageField = '';

    public function imageBeforeSave($model)
    {
        $storagePath = $model->getStorePath();
        if ($model->_removeImageFlag)
        {
            // removing file
            // set attribute to null
            unlink( $storagePath.$model->{$this->imageField} );
            $model->{$this->imageField} = null;
        }
        $model->_image = CUploadedFile::getInstance($model, '_image');
        if ($model->validate() && !empty($model->_image))
        {
            if ($model->{$this->imageField})
            {
                unlink( $storagePath.$model->{$this->imageField} );
                $model->{$this->imageField} = null;
            }
            // saving file from CUploadFile instance $model->_image
            if (!is_dir($storagePath))
                mkdir($storagePath, 755);
            $model->_image->saveAs( $storagePath.$model->_image->name );
            $model->{$this->imageField} = $model->_image->name;
        }
    }
}