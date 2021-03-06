<?php

Yii::import('application.models.MenuItem');

class Menu extends CActiveRecord
{
    const NONE = 0;
    const MAIN_MENU = 1;
    const MAIN_MENU_SECOND = 2;
    const FOOTER_MENU = 3;
    const LEFT_MENU_MAIN = 4;
    const LEFT_MENU_NEWS = 5;
    const LEFT_MENU_CONTACTS = 6;
    const PAGE_TOP_MAP = 7;             // Верхнее меню на карте
    const PAGE_TOP_STRUCTURE = 8;       // Верхнее меню в инфраструктуре


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
            array('name', 'required'),
            array('visible', 'boolean'),
        );
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'onSite' => array(
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

    public static function getMenuTypes()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id, name';
        $menus = Menu::model()->findAll($criteria);
        
        $arr = array();
        foreach ($menus as $menu) {
            $arr[$menu->id] = $menu->name;
        }
        return $arr;
    }
}
