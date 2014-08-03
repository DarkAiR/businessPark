<?php

/**
 * Рубрики
 */
class Faq extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'visible' => 'Показывать',
            'orderNum' => 'Порядок',
        );
    }

    public function rules()
    {
        return array(
            array('question', 'required'),
            array('question, answer', 'safe'),
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

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('question', $this->question, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort'=>array(
                'defaultOrder' => 'orderNum ASC',
            )
        ));
    }
}
