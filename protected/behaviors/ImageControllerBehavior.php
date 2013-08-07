<?php

class ImageControllerBehavior extends CBehavior
{
    public $imageField = '';
    public $innerImageField = '_image';
    public $innerRemoveBtnField = '_removeImageFlag';

    public function imageBeforeSave($model, $storagePath)
    {
        if ($model->{$this->innerRemoveBtnField})
        {
            // removing file
            // set attribute to null
            unlink( $storagePath.$model->{$this->imageField} );
            $model->{$this->imageField} = null;
        }

        $model->{$this->innerImageField} = CUploadedFile::getInstance($model, $this->innerImageField);
        if ($model->validate() && !empty($model->{$this->innerImageField}))
        {
            if ($model->{$this->imageField})
            {
                unlink( $storagePath.$model->{$this->imageField} );
                $model->{$this->imageField} = null;
            }
            // saving file from CUploadFile instance $model->{$this->innerImageField}
            if (!is_dir($storagePath))
                mkdir($storagePath, 755);

            $ext = strrchr($model->{$this->innerImageField}->name, '.');
            $imageName = md5(time().$model->{$this->innerImageField}->name).($ext?$ext:'');

            $model->{$this->innerImageField}->saveAs( $storagePath.$imageName );
            $model->{$this->imageField} = $imageName;
        }
    }
}