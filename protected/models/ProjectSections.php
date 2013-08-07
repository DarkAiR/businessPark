<?php

/**
 * Рубрики
 */
class ProjectSections extends CActiveRecord
{
    const IMAGE_WIDTH = 324;        // (18px*18)
    const IMAGE_HEIGHT = 306;       // (18px*17)

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
                'storagePath' => 'projectsections',
                'imageWidth' => self::IMAGE_WIDTH,
                'imageHeight' => self::IMAGE_HEIGHT,
                'imageField' => 'image',
            )
        );
    }

    public function relations()
    {
        return array(
            'projects' => array(self::HAS_MANY, 'Projects', 'sectionId', 'order'=>'items.orderNum ASC'),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->imageLabels(),
            array(
                'name' => 'Заголовок для отображения в меню',
                'title' => 'Заголовок',
                'desc' => 'Основной текст',
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
                array('name, title, visible', 'required'),
                array('name, title, desc', 'safe'),
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
