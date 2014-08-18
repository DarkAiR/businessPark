<?php

class ImageControllerBehavior extends CBehavior
{
    public $imageField = '';
    public $innerImageField = '_image';
    public $innerRemoveBtnField = '_removeImageFlag';
    public $imageWidth = null;
    public $imageHeight = null;
    public $resize = true;

    public function imageBeforeSave($model, $storagePath)
    {
        // disable resize if 
        $isResize = (empty($this->imageWidth) && empty($this->imageHeight)) ? false : $this->resize;

        if ($model->{$this->innerRemoveBtnField})
        {
            // removing file
            // set attribute to null
            unlink( $storagePath.$model->{$this->imageField} );
            $model->{$this->imageField} = null;
        }

        $model->{$this->innerImageField} = CUploadedFile::getInstance($model, $this->innerImageField);

        if ($model->validate(array($this->innerImageField)) && !empty($model->{$this->innerImageField}))
        {
            if ($model->{$this->imageField})
            {
                unlink( $storagePath.$model->{$this->imageField} );
                $model->{$this->imageField} = null;
            }
            // saving file from CUploadFile instance $model->{$this->innerImageField}
            if (!is_dir($storagePath))
                mkdir($storagePath, 755);

            $imageName = basename($model->{$this->innerImageField}->name);
            $ext = strrchr($imageName, '.');
            $imageName = md5(time().$imageName).($ext?$ext:'');

            $model->{$this->innerImageField}->saveAs( $storagePath.$imageName );
            
            if ($isResize) {
                $image = Yii::app()->image->load($storagePath.$imageName);
                if (empty($this->imageWidth)) {
                    // resize by height
                    $image->resize(null, $this->imageHeight);
                } else
                if (empty($this->imageHeight)) {
                    // resize by width
                    $image->resize($this->imageWidth, null);
                } else {
                    // normal resize
                    $image->resize($this->imageWidth, $this->imageHeight);
                }
                $image->save();
            }

            $model->{$this->imageField} = $imageName;
        }
    }
}