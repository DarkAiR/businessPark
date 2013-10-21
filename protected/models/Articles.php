<?php

/**
 * Статья
 */
class Articles extends CActiveRecord
{
    const TYPE_CUSTOM = 0;              // Произольная статья
    const TYPE_ABOUT = 1;               // О нас


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'type' => 'Тип статьи',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'visible' => 'Показывать',
        );
    }

    public function rules()
    {
        return array(
            array('title, text', 'safe'),
            array('visible', 'boolean'),
            array('type', 'numerical', 'integerOnly'=>true),
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

    public function byType($type)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.type = '.$type,
        ));
        return $this;
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('type', $this->type);
        //$criteria->compare('title', $this->title, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getTypeNames()
    {
        return array(
            self::TYPE_CUSTOM => 'Произвольная',
            self::TYPE_ABOUT => 'О нас',
        );
    }
}
