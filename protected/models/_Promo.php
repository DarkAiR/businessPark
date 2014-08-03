<?php

/**
 * Промо
 */
class Promo extends CActiveRecord
{
    const DEFAULT_ID = 1;

    const IMAGE_WIDTH = 288;        // 18px * 16
    const IMAGE_HEIGHT = 234;       // 18px * 13

    public $_image = null; //UploadedFile[]
    public $_removeImageFlag = false; // bool

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
                'storagePath' => 'promo',
                'imageWidth' => self::IMAGE_WIDTH,
                'imageHeight' => self::IMAGE_HEIGHT,
                'imageField' => 'image',
                'imageExt' => 'jpg, png',
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
        return array_merge(
            $this->imageBehavior->imageLabels(),
            array(
                'title' => 'Заголовок',
                'motto' => 'Девиз',
                'text' => 'Описание',
                'visible' => 'Показывать',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            array(
                array('title, motto, text', 'safe'),
                array('visible', 'boolean'),
            )
        );
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'onSite' => array(
                'condition' => $alias.'.visible = 1',
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getImageUrl()
    {
        return $this->imageBehavior->getImageUrl();
    }

    protected function afterDelete()
    {
        $this->imageBehavior->imageAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->imageBehavior->imageAfterFind();
        return parent::afterFind();
    }
}
