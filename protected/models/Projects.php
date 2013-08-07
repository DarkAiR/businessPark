<?php

/**
 * Проект
 */
class Projects extends CActiveRecord
{
    const IMAGE_WIDTH = 216;        // (18px*12)
    const IMAGE_HEIGHT = 216;       // (18px*12)

    const LINK_ICON_WIDTH = 18;     // (18px*1)
    const LINK_ICON_HEIGHT = 18;    // (18px*1)

    public $_image = null; //UploadedFile[]
    public $_removeImageFlag = false; // bool

    public $_linkIcon = null; //UploadedFile[]
    public $_removeLinkIconFlag = false; // bool

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
            ),
            'linkIconBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'projects/icons',
                'imageWidth' => self::LINK_ICON_WIDTH,
                'imageHeight' => self::LINK_ICON_HEIGHT,
                'imageField' => 'linkIcon',
                'imageLabel' => 'Иконка ссылки',
                'innerImageField' => '_linkIcon',
                'innerRemoveBtnField' => '_removeLinkIconFlag',
            ),
            'timeBehavior' => array(
                'class' => 'application.behaviors.TimeBehavior',
                'createTimeField' => 'createTime',
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
            $this->imageBehavior->imageLabels(),
            $this->linkIconBehavior->imageLabels(),
            $this->timeLabels(),
            array(
                'desc' => 'Краткое описание',
                'sectionId' => 'Раздел',
                'visible' => 'Показывать',
                'orderNum' => 'Порядок сортировки',

                'title' => 'Заголовок',
                'goal' => 'Задача',
                'publishTime' => 'Дата выпуска',
                'link' => 'Ссылка',
                'resultText' => 'Текст результата',
                'processText' => 'Текст процесса',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            $this->linkIconBehavior->imageRules(),
            $this->timeRules(),
            array(
                array('sectionId', 'required'),
                array('title, goal, desc, resultText, processText', 'safe'),
                array('visible', 'boolean'),
                array('orderNum, sectionId', 'numerical', 'integerOnly'=>true),
                array('publishTime', 'CDateValidator', 'format'=>'dd.MM.yyyy'),
                array('link', 'CUrlValidator'),
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

    public function bySection($sectionId)
    {
        $this->getDbCriteria()->addInCondition('sectionId', array($sectionId));
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

    protected function afterDelete()
    {
        $this->imageBehavior->imageAfterDelete();
        $this->linkIconBehavior->imageAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->imageBehavior->imageAfterFind();
        $this->linkIconBehavior->imageAfterFind();
        $this->timeAfterFind();

        $this->publishTime = date('d.m.Y', $this->publishTime);

        return parent::afterFind();
    }

    protected function beforeSave()
    {
        $this->timeCreate();
        $this->publishTime = strtotime($this->publishTime);
        return parent::beforeSave();
    }
}
