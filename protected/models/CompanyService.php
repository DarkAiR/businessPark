<?php

/**
 * Услуги компании
 */
class CompanyService extends CActiveRecord
{
    const TYPE_BASE = 1;            // Базовые услуги
    const TYPE_ADDITIONAL = 2;      // Дополнительные услуги

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'type' => 'Тип услуги',
            'text' => 'Текст',
            'visible' => 'Показывать',
            'orderNum' => 'Порядок',
        );
    }

    public function rules()
    {
        return array(
            array('type, text', 'required'),
            array('visible', 'boolean'),
            array('orderNum', 'numerical', 'integerOnly'=>true),
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
                'order' => $alias.'.orderNum ASC',
            ),
        );
    }

    public function byType($type)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.type = '.$type,
        ));
        return $this;
    }

    public function byTypeStr($typeStr)
    {
        $types = array_flip(self::getTypeQueryStr());
        $type  = isset($types[$typeStr]) ? $types[$typeStr] : self::TYPE_BASE;
        return $this->byType($type);
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('text', $this->text, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder' => 'type ASC, orderNum ASC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    public function getTypeNames()
    {
        return array(
            self::TYPE_BASE => 'Базовая',
            self::TYPE_ADDITIONAL => 'Дополнительная',
        );
    }

    public static function getTypeQueryStr()
    {
        return array(
            self::TYPE_BASE => 'base',
            self::TYPE_ADDITIONAL => 'additional',
        );
    }
}
