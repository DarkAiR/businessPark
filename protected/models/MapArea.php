<?php

/**
 * Участки
 */
class MapArea extends CActiveRecord
{
    // Размер всех площадей в гектарах
    const TOTAL_SQUARE = 180;

    // Типы стоимости
    const PRICE_RUB = 0;
    const PRICE_THOUSAND = 1;
    const PRICE_MILLION = 2; 

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
            'price'         => 'Стоимость',
            'priceType'     => 'Измерение стоимости',
            'resident'      => 'Резидент',
            'busy'          => 'Занят',
        );
    }

    public function rules()
    {
        return array(
            array('resident', 'safe'),
            array('cadastral, width, height', 'numerical', 'integerOnly'=>true),
            array('square, price', 'numerical'),
            array('priceType', 'in', 'range'=>array_keys(MapArea::getPriceTypes())),
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
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => array(
                    'cadastral' => CSort::SORT_ASC,
                )
            )
        ));
    }

    public static function getPriceTypes()
    {
        return array(
            self::PRICE_RUB => 'руб.',
            self::PRICE_THOUSAND => 'тыс.руб.',
            self::PRICE_MILLION => 'млн.руб.'
        );
    }

    public function getPriceStr()
    {
        if (!$this->price)
            return '';

        $priceTypes = MapArea::getPriceTypes();
        if (!isset($priceTypes[$this->priceType]))
            return '';

        return $this->price.' '.$priceTypes[$this->priceType];
    }
}
