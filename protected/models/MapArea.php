<?php

/**
 * Участки
 */
class MapArea extends CActiveRecord
{
    // Размер всех площадей в гектарах
    const TOTAL_SQUARE = 180;


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'cadastral'     => 'Кадастровый номер',
            'square'        => 'Площадь в га',
            'width'         => 'Ширина',
            'height'        => 'Высота',
            'size'          => 'Размеры',
            'resident'      => 'Резидент',
            'busy'          => 'Занят',
        );
    }

    public function rules()
    {
        return array(
            array('resident', 'safe'),
            array('square, cadastral, width, height', 'numerical', 'integerOnly'=>true),
            array('busy', 'boolean'),
            array('cadastral', 'required'),
            array('cadastral', 'unique', 'allowEmpty'=>false, 'skipOnError'=>false),
        );
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'isBusy' => array(
                'condition' => $alias.'.busy = 1',
            ),
            'orderDefault' => array(
                'order' => $alias.'.cadastral ASC',
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('cadastral', $this->cadastral, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'busy' => CSort::SORT_ASC,
                    'cadastral' => CSort::SORT_ASC,
                )
            )
        ));
    }
}
