<?php

class AdminSitemenuController extends MAdminController
{
    public $modelName = 'SiteMenuItem';
    public $modelHumanTitle = array('пункт', 'пункта', 'пунктов');

    /**
     * @param User $model
     * @return array
     */
    public function getEditFormElements($model)
    {
        $parents = array('0'=>'');
        $parentRecords = CActiveRecord::model($this->modelName)->byParent(0)->orderDefault()->findAll();
        foreach ($parentRecords as $record)
        {
            $parents[$record->id] = $record->label;
            foreach ($record->children as $childRecord)
                $parents[$childRecord->id] = ' - - '.$childRecord->label;
        }

        $res = array(
            'label' => array(
                'type' => 'textField',
            ),
            'link' => array(
                'type' => 'textField',
            ),
            'visible' => array(
                'type' => 'checkBox',
            ),
            'parentItemId'=>array(
                'type'=>'dropdownlist',
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
            //'orderNum',
            'label',
            'link',
            'parentItemId',
            'visible',
        );

        return $attributes;
    }

    /**
     * @param User $model
     * @param array $attributes
     */
    public function beforeSetAttributes($model, &$attributes)
    {
        //if (empty($attributes['password'])) {
         //   unset($attributes['password']);
        //}

        parent::beforeSetAttributes($model, $attributes);
    }
}
