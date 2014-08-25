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

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Заголовок',
            'text' => 'Текст',
            'visible' => 'Показывать',
            'orderNum' => 'Порядок шагов',
        );
    }


    public function rules()
    {
        return array(
            array('title, text', 'safe'),
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
        if (empty($this->orderNum)) {
            // Автоматическое выставление orderNum
            $sql = 'SELECT MAX(orderNum)+1 as orderNum FROM '.$this->tableName();
            $orderNum = Yii::app()->db->createCommand($sql)->queryScalar();
            $this->orderNum = ($orderNum === null) ? 1 : $orderNum;
        } else {
            // Проверяем существующий orderNum
            $sql = 'SELECT id, count(*) as count FROM '.$this->tableName().' WHERE orderNum='.$this->orderNum;
            $row = Yii::app()->db->createCommand($sql)->queryRow();
            if ($row['id'] != $this->id  &&  $row['count'] > 0) {
                // Пересортируем все записи до конца
                $sql = 'UPDATE '.$this->tableName().' SET orderNum = orderNum+1 WHERE orderNum >= '.$this->orderNum;
                Yii::app()->db->createCommand($sql)->execute();
            }
        }

        return parent::beforeSave();
    }
}
