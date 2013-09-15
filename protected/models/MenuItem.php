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
            array('menuId, name, link', 'required'),
            array('visible', 'boolean'),
            array('orderNum, parentItemId', 'numerical', 'integerOnly'=>true),
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
                'order' => $alias.'.parentItemId ASC, '.$alias.'.orderNum ASC',
            ),
        );
    }

    public function search()
    {
        $rowData = $this->getRowData(0);
        return new CArrayDataProvider(
            $rowData,
            array(
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            )
        );
    }

    private function getRowData($parentId)
    {
        $data = Yii::app()->db->createCommand('SELECT * from `MenuItem` WHERE parentItemId='.$parentId.' ORDER BY orderNum ASC')->queryAll();
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

    public function byMenuId($menuId)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.menuId = '.$menuId,
        ));
        return $this;
    }
}
