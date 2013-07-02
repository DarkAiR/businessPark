<?php

class SiteMenuItem extends CActiveRecord
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
            'children' => array(self::HAS_MANY, 'SiteMenuItem', 'parentItemId', 'order'=>'children.orderNum ASC', 'condition' => 'children.visible = 1'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'parentItemId' => 'Родительский раздел',
            'visible' => 'Показывать',
            'link' => 'Ссылка',
            'label' => 'Текст',
            'orderNum' => 'Порядковый номер',
            'type' => 'Тип'
        );
    }

    public function rules()
    {
        return array(
            array('label, link, visible', 'required'),
            array('visible', 'boolean'),
            array('orderNum, parentItemId, type', 'numerical', 'integerOnly'=>true),
        );
    }

    public function scopes()
    {
        return array(
            'onSite' =>
                array(
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

    public function byParent($parent)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $this->getTableAlias().'.parentItemId = '.$parent,
        ));
        return $this;
    }

    public function orderDefault()
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'order' => $alias.'.parentItemId ASC, '.$alias.'.orderNum ASC',
        ));
        return $this;
    }
}
