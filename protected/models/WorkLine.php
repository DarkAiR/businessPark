<?php

/**
 * От слов к делу
 */
class WorkLine extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'orderBehavior' => array(
                'class' => 'application.behaviors.OrderBehavior',
            ),
        );
    }

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->orderBehavior->orderLabels(),
            array(
                'title' => 'Заголовок',
                'text' => 'Текст',
                'visible' => 'Показывать',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->orderBehavior->orderRules(),
            array(
                array('title, text', 'safe'),
                array('visible', 'boolean'),
            )
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


    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'orderNum' => CSort::SORT_ASC,
                )
            )
        ));
    }

    public function beforeSave()
    {
        $this->orderBehavior->orderBeforeSave();
        return parent::beforeSave();
    }
}
