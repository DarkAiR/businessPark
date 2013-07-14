<?php

class Menu extends CActiveRecord
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
            'items' => array(self::HAS_MANY, 'MenuItem', 'menuId', 'order'=>'items.orderNum ASC'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Название',
            'visible' => 'Показывать',
        );
    }

    public function rules()
    {
        return array(
            array('name, visible', 'required'),
            array('visible', 'boolean'),
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

        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
