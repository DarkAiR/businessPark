<?php

class ImageBehavior extends CActiveRecordBehavior
{
    public $storagePath = '';
    public $imageWidth = 0;
    public $imageHeight = 0;
    public $imageMaxWidth = 0;
    public $imageMaxHeight = 0;
    public $imageExt = 'jpg';
    public $imageField = '';

    public $_image = null; // CUploadedFile[]
    public $_removeImageFlag = false; // bool

    public function imageLabels()
    {
        $arr = array(
            $this->imageField => 'Изображение',
            '_removeImageFlag' => 'Удалить'
        );

        if (!empty($this->imageWidth) && !empty($this->imageHeight))
            $arr['_image'] = 'Изображение '.$this->imageWidth.'x'.$this->imageHeight;
        elseif (!empty($this->imageMaxWidth) && !empty($this->imageMaxHeight))
            $arr['_image'] = 'Изображение не больше '.$this->imageMaxWidth.'x'.$this->imageMaxHeight;
        else
            $arr['_image'] = 'Изображение';
        return $arr;
    }

    public function imageRules()
    {
        $arr = array('_image', 'ext.validators.EImageValidator', 'allowEmpty'=>true);
        if (!empty($this->imageWidth))      $arr['width'] = $this->imageWidth;
        if (!empty($this->imageHeight))     $arr['height'] = $this->imageHeight; 
        if (!empty($this->imageMaxWidth))   $arr['maxWidth'] = $this->imageMaxWidth;
        if (!empty($this->imageMaxHeight))  $arr['maxHeight'] = $this->imageMaxHeight; 

        return array(
            array('_image', 'file', 'types'=>$this->imageExt, 'allowEmpty'=>true),
            $arr,
        );
    }

    public function getStorePath()
    {
        return Yii::getPathOfAlias('webroot.store.'.$this->storagePath).'/';
    }

    public function getImageUrl()
    {
        return CHtml::normalizeUrl('/store/'.$this->storagePath.'/'.$this->owner->{$this->imageField});
    }

    public function imageAfterDelete()
    {
        if ($this->owner->{$this->imageField})
            unlink( $this->getStorePath().$this->owner->{$this->imageField} );
    }

    public function imageAfterFind()
    {
        $this->_image = $this->getImageUrl();
    }
}