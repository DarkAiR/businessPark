<?php

class MainWorkItem extends CActiveRecord
{
    const IMAGE_WIDTH = 792;        // (18px*44)
    const IMAGE_HEIGHT = 324;       // (18px*18)

    const STORAGE_PATH = 'projects';

    public $_image; // CUploadedFile[]
    public $_removeImageFlag; // bool

    public $descCorrect = '';       // Испрвленный desc для отображения

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'manyToMany' => array(
                'class' => 'lib.ar-relation-behavior.EActiveRecordRelationBehavior',
            ),
        );
    }

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            //'image'     => 'Изображение '.self::IMAGE_WIDTH.'x'.self::IMAGE_HEIGHT,
            '_image'    => 'Изображение '.self::IMAGE_WIDTH.'x'.self::IMAGE_HEIGHT,
            '_removeImageFlag' => 'Удалить',
            'visible'   => 'Показывать',
            'title'     => 'Заголовок',
            'desc'      => 'Описание',
            'orderNum'  => 'Порядковый номер'
        );
    }

    public function rules()
    {
        return array(
            array('visible', 'required'),
            array('visible', 'boolean'),
            array('orderNum', 'numerical', 'integerOnly'=>true),
            array('title, desc', 'safe'),
            array('_image', 'file', 'types'=>'jpg', 'allowEmpty'=>true),
            array('_image', 'ext.validators.EImageValidator', 'width'=>self::IMAGE_WIDTH, 'height'=>self::IMAGE_HEIGHT, 'allowEmpty'=>true),
        );        
    }

    public function scopes()
    {
        return array(
            'onSite' => array(
                'condition' => $this->getTableAlias().'.visible = 1',
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        //$criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function orderDefault()
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'order' => $alias.'.orderNum ASC',
        ));
        return $this;
    }

    public function getStorePath()
    {
        return Yii::getPathOfAlias('webroot.store.'.self::STORAGE_PATH).'/';
    }

    public function getImageUrl()
    {
        return CHtml::normalizeUrl('/store/'.self::STORAGE_PATH.'/'.$this->image);
    }

    protected function afterDelete()
    {
        if ($this->image)
            unlink( $this->getStorePath().$this->image );

        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->descCorrect = str_replace(array("\r\n","\n","\r"), "", $this->desc);
        $this->_image = $this->getImageUrl();
        return parent::afterFind();
    }

    protected function beforeSave()
    {
        return parent::beforeSave();
    }
}
