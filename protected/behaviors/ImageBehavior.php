<?php

class ImageBehavior extends CActiveRecordBehavior
{
    public $storagePath = '';
    public $imageWidth = 0;
    public $imageHeight = 0;
    public $imageField = '';

    public $_image = null; // CUploadedFile[]
    public $_removeImageFlag = false; // bool

    public function imageLabels()
    {
        return array(
            $this->imageField => 'Изображение',
            '_image' => 'Изображение '.$this->imageWidth.'x'.$this->imageHeight,
            '_removeImageFlag' => 'Удалить'
        );
    }

    public function imageRules()
    {
        return array(
            array('_image', 'file', 'types'=>'jpg', 'allowEmpty'=>true),
            array('_image', 'ext.validators.EImageValidator', 'width'=>$this->imageWidth, 'height'=>$this->imageHeight, 'allowEmpty'=>true),
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