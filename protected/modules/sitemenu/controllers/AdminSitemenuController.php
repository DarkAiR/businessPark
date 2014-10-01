<?php

class AdminSitemenuController extends MAdminController
{
    public $modelName = 'MenuItem';
    public $modelHumanTitle = array('пункт', 'пункта', 'пунктов');
    public $allowedRoles = 'admin';

    protected $templateList = '/list';


    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageControllerBehavior',
                'imageField' => 'image',
            ),
        );
    }

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
            '_image' => array(
                'class' => 'ext.ImageFileRowWidget',
                'uploadedFileFieldName' => '_image',
                'removeImageFieldName' => '_removeImageFlag',
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
            $this->getOrderColumn(),
            'parentItemId',
            'menuId',
            $this->getImageColumn('image', 'getIconUrl()'),
            'name',
            $this->getVisibleColumn(),
            $this->getButtonsColumn(),
        );

        return $attributes;
    }

    public function beforeSave($model)
    {
        $this->imageBehavior->imageBeforeSave($model, $model->imageBehavior->getStorePath());
        parent::beforeSave($model);
    }
}
