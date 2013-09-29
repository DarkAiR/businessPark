<?php

/**
 * Вакансия
 */
class Vacancy extends CActiveRecord
{
    const IMAGE_WIDTH = 198;        // 18px * 11
    const IMAGE_HEIGHT = 198;       // 18px * 11

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
                'storagePath' => 'vacancy',
                'imageWidth' => self::IMAGE_WIDTH,
                'imageHeight' => self::IMAGE_HEIGHT,
                'imageField' => 'image',
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
                'title' => 'Название должности',
                'text' => 'Описание',
                'visible' => 'Показывать',
                'orderNum' => 'Порядок сортировки',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            array(
                array('title', 'required'),
                array('title, text', 'safe'),
                array('visible', 'boolean'),
                array('orderNum', 'numerical', 'integerOnly'=>true),
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
            'orderDefault' => array(
                'order' => $alias.'.orderNum ASC',
            ),
        );
    }

    public function byLimit($limit)
    {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
        ));
        return $this;
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('title', $this->title, true);
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
