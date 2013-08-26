<?php

/**
 * Собственный проект
 */
class ProjectsOwn extends CActiveRecord
{
    // Типы проекта
    const TYPE_IN_PROGRESS = 0;
    const TYPE_OWN_PROJECT = 1;

    const IMAGE_WIDTH = 216;        // (18px*12)
    const IMAGE_HEIGHT = 90;        // (18px*5)

    public $_image = null; //UploadedFile[]
    public $_removeImageFlag = false; // bool

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            // 'manyToMany' => array(
            //     'class' => 'lib.ar-relation-behavior.EActiveRecordRelationBehavior',
            // ),
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'projects/own',
                'imageMaxWidth' => self::IMAGE_WIDTH,
                'imageMaxHeight' => self::IMAGE_HEIGHT,
                'imageExt' => 'jpg, png',
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
                'desc' => 'Краткое описание',
                'link' => 'Ссылка на сайт',
                'type' => 'Статус',
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
                array('type, visible', 'required'),
                array('desc, link', 'safe'),
                array('link', 'CUrlValidator'),
                array('visible', 'boolean'),
                array('orderNum, type', 'numerical', 'integerOnly'=>true),
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
        //$criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Получить типы проекты
     */
    public static function getTypes()
    {
        return array(
            self::TYPE_IN_PROGRESS => 'В процессе разработки',
            self::TYPE_OWN_PROJECT => 'Собственный проект',
        );
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
