<?php

/**
 * Новость
 */
class News extends CActiveRecord
{
    public $createTimeDate = '';
    public $createTimeTime = '';


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
            'timeBehavior' => array(
                'class' => 'application.behaviors.TimeBehavior',
                'createTimeField' => 'createTime',
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
            $this->timeLabels(),
            array(
                'title' => 'Заголовок',
                'shortDesc' => 'Короткое описание',
                'desc' => 'Текст',
                'sectionId' => 'Раздел',
                'visible' => 'Показывать',
                'orderNum' => 'Порядок сортировки',
                'newsLink' => 'Ссылка на новость',
                'createTimeTime' => 'Время создания',
                'createTimeDate' => 'Дата создания'
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->timeRules(),
            array(
                array('sectionId', 'required'),
                array('title, desc, shortDesc', 'safe'),
                array('visible', 'boolean'),
                array('orderNum, sectionId', 'numerical', 'integerOnly'=>true),
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


    public function byYear($year)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => "DATE_FORMAT(FROM_UNIXTIME(createTime),'%Y') = :year",
            'params' => array(
                'year' => $year,
            ),
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

    public function getNewsLink()
    {
        return CHtml::normalizeUrl( array(0=>'/news/news/show', 'id'=>$this->id) );
    }

    protected function afterFind()
    {
        $this->timeAfterFind();

        $this->createTimeDate = date('d.m.Y', $this->createTime);
        $this->createTimeTime = date('H:i', $this->createTime);

        return parent::afterFind();
    }

    protected function beforeSave()
    {
        //var_dump($this->createTimeDate);
        //var_dump($this->createTimeTime);
        //die;
        if (!empty($this->createTimeDate) && !empty($this->createTimeTime))
            $this->createTime = strtotime($this->createTimeDate.' '.$this->createTimeTime);

        $this->timeCreate();
        return parent::beforeSave();
    }
}
