<?php

/**
 * Участки инфраструктуры
 */
class MapInfrastructure extends CActiveRecord
{
    const TYPE_RED = 1;
    const TYPE_GREEN = 2;
    const TYPE_YELLOW = 3;
    const TYPE_BLUE = 4;
    const TYPE_PURPLE = 5;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getTypes()
    {
        return array(
            self::TYPE_RED => 'Электроснабжение',
            self::TYPE_GREEN => 'Ливневая канализация',
            self::TYPE_YELLOW => 'Газоснабжение',
            self::TYPE_BLUE => 'Водоснабжение',
            self::TYPE_PURPLE => 'Водоотведение'
        );
    }

    /**
     * Получить название типа на карте
     */
    public function getTypeMapName()
    {
        static $arr = array(
            self::TYPE_RED => 'red',
            self::TYPE_GREEN => 'green',
            self::TYPE_YELLOW => 'yellow',
            self::TYPE_BLUE => 'blue',
            self::TYPE_PURPLE => 'purple'
        );
        if (isset($arr[$this->type]))
            return $arr[$this->type];
        return '';
    }

    public function attributeLabels()
    {
        return array(
            'type'      => 'Тип',
            'square'    => 'Площадь в га',
            'number'    => 'Номер',
            'desc'      => 'Описание',
        );
    }

    public function rules()
    {
        return array(
            array('type', 'in', 'range' => array_keys($this->getTypes())),
            array('square', 'numerical'),
            array('number', 'required'),
            array('number, desc', 'safe'),
        );
    }

    public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'orderDefault' => array(
                'order' => $alias.'.type ASC, '.$alias.'.id ASC',
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'type' => CSort::SORT_ASC,
                    'id' => CSort::SORT_ASC,
                )
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
}
