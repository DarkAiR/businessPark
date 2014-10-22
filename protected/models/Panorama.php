<?php

/**
 * Панорамы
 */
class Panorama extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'createDate'    => 'Дата',
            'swf'           => 'Файл swf',
            'mov'           => 'Файл mov',
            'visible'       => 'Показывать',
        );
    }

    public function rules()
    {
        return array(
            array('createDate, swf', 'required'),
            array('createDate', 'date', 'allowEmpty'=>false, 'format'=>'MM.yyyy'),
            array('swf, mov', 'safe'),
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
            'orderDefault' => array(
                'order' => $alias.'.createDate DESC',
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'createDate' => CSort::SORT_DESC,
                    'visible' => CSort::SORT_DESC,
                )
            )
        ));
    }
}
