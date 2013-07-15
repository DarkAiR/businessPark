<?php

class MainWorkItem extends CActiveRecord
{
    const IMAGE_WIDTH = 792;        // (18px*44)
    const IMAGE_HEIGHT = 324;       // (18px*18)

    public $descCorrect = '';       // Исправленный desc для отображения

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
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'mainworks',
                'imageWidth' => self::IMAGE_WIDTH,
                'imageHeight' => self::IMAGE_HEIGHT,
                'imageField' => 'image',
            )
        );
    }

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->imageLabels(),
            array(
                'visible'   => 'Показывать',
                'title'     => 'Заголовок',
                'desc'      => 'Описание',
                'orderNum'  => 'Порядковый номер'
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageRules(),
            array(
                array('visible', 'required'),
                array('visible', 'boolean'),
                array('orderNum', 'numerical', 'integerOnly'=>true),
                array('title, desc', 'safe'),
            )
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

    protected function afterDelete()
    {
        $this->imageAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->descCorrect = str_replace(array("\r\n","\n","\r"), "", $this->desc);
        $this->imageAfterFind();
        return parent::afterFind();
    }
}
