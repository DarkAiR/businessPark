<?php

/**
 * Проект
 */
class Projects extends CActiveRecord
{
    const IMAGE_WIDTH = 216;        // (18px*12)
    const IMAGE_HEIGHT = 216;       // (18px*12)

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
                'storagePath' => 'projects',
                'imageWidth' => self::IMAGE_WIDTH,
                'imageHeight' => self::IMAGE_HEIGHT,
                'imageField' => 'image',
            )
        );
    }

    public function relations()
    {
        return array(
            'section' => array(self::BELONGS_TO, 'ProjectSections', 'sectionId', 'order'=>'items.orderNum ASC'),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->imageLabels(),
            array(
                'desc' => 'Краткое описание',
                'sectionId' => 'Раздел',
                'visible' => 'Показывать',
                'orderNum' => 'Порядок сортировки',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageRules(),
            array(
                array('sectionId, visible', 'required'),
                array('desc', 'safe'),
                array('visible', 'boolean'),
                array('orderNum, sectionId', 'numerical', 'integerOnly'=>true),
            )
        );
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'onSite' =>
                array(
                    'condition' => $alias.'.visible = 1',
                ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterDelete()
    {
        $this->imageAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->imageAfterFind();
        return parent::afterFind();
    }
}
