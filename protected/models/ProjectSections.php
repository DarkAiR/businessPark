<?php

/**
 * @property int id
 * @property string name
 */
class ProjectSections extends CActiveRecord
{
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
            'name' => 'Имя рубрики',
        );
    }

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name', 'safe', 'on' => 'search'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
