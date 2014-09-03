<?php

class AdminSitemenuController extends MAdminController
{
    public $modelName = 'MenuItem';
    public $modelHumanTitle = array('пункт', 'пункта', 'пунктов');
    public $allowedRoles = 'admin';

    protected $templateList = '/list';


    /**
     * @param User $model
     * @return array
     */
    public function getEditFormElements($model)
    {
        $menu = Menu::model()->findAll();
        $menus = array();
        foreach ($menu as $m)
        {
            $menus[$m->id] = $m->name;
        }

        $parents = array('0'=>'[корневой элемент]');
        $parentRecords = CActiveRecord::model($this->modelName)->byParent(0)->orderDefault()->findAll();
        foreach ($parentRecords as $record)
        {
            $menuName = $menus[$record->menuId];
            $parents[$menuName][$record->id] = $record->name;
            foreach ($record->children as $childRecord)
                $parents[$childRecord->id] = '- '.$childRecord->name;
        }

        $res = array(
            'menuId' => array(
                'type' => 'dropdownlist',
                'data' => $menus,
                'empty' => 'Выбрать',
                'htmlOptions' => array(
                    'onchange' => 'console.log("hello world");'
                )
            ),
            'name' => array(
                'type' => 'textField',
            ),
            'link' => array(
                'type' => 'textField',
            ),
            'visible' => array(
                'type' => 'checkBox',
            ),
            'parentItemId'=>array(
                'type' => 'dropdownlist',
                'data' => $parents,
                'empty' => 'Выбрать',
                'options' => array($model->id => array('disabled' => 'disabled'))
            ),
        );
        return $res;
    }

    public function getTableColumns()
    {
        $attributes = array(
            'id',
            'parentItemId',
            'orderNum',
            'menuId',
            'name',
            'visible',
            $this->getButtonsColumn(),
        );

        return $attributes;
    }
}
