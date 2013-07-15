<?php

class MenuItem extends CActiveRecord
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
            'children' => array(self::HAS_MANY, 'MenuItem', 'parentItemId', 'order'=>'children.orderNum ASC'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'menuId' => 'Меню',
            'parentItemId' => 'Родительский раздел',
            'visible' => 'Показывать',
            'link' => 'Ссылка',
            'name' => 'Текст',
            'orderNum' => 'Порядковый номер'
        );
    }

    public function rules()
    {
        return array(
            array('menuId, name, link, visible', 'required'),
            array('visible', 'boolean'),
            array('orderNum, parentItemId', 'numerical', 'integerOnly'=>true),
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
/*        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
*/
        $rowData = $this->getRowData(0);
        return new CArrayDataProvider( $rowData );
    }

    private function getRowData($parentId)
    {
        $data = Yii::app()->db->createCommand('SELECT * from `menuitem` WHERE parentItemId='.$parentId.' ORDER BY orderNum ASC')->queryAll();
        $rowData = array();
        foreach ($data as $row)
        {
            $rowData[] = $row;
            $data2 = $this->getRowData($row['id']);
            foreach ($data2 as $row2)
                $rowData[] = $row2;
        }
        return $rowData;
    }

    public function byParent($parent)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.parentItemId = '.$parent,
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
