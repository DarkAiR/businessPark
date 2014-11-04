<?php

class DocumentsBehavior extends CActiveRecordBehavior
{
    public $storagePath = '';
    public $docExt = 'pdf';
    public $docField = '';

    public $innerField = '_docs';
    public $innerRemoveField = '_removeDocs';


    public function docLabels()
    {
        $arr = array(
            $this->innerField => 'Файлы',
            $this->innerRemoveField => 'Удалить'
        );
        return $arr;
    }

    public function docRules()
    {
        return array(
            array($this->innerField, 'ext.validators.DocumentsValidator', 'types'=>$this->docExt, 'allowEmpty'=>true)
        );
    }

    public function getStorePath()
    {
        return Yii::getPathOfAlias('webroot.store.'.$this->storagePath).'/';
    }

    public function docAfterDelete()
    {
        if (!is_array($this->owner->{$this->docField}))
            return;

        if (count($this->owner->{$this->docField}) > 0) {
            foreach ($this->owner->{$this->docField} as $doc) {
                @unlink( $this->getStorePath().$doc['name'] );
                @unlink( $this->getStorePath().'original/'.$doc['name'] );
            }
        }
    }

    public function docAfterFind()
    {
        $this->owner->{$this->innerField} = $this->owner->{$this->docField};
    }
}