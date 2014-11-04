<?php

/**
 * Документы для раздела Резидентам
 */
class WorkLinePdf extends CActiveRecord
{
    public $_docs = null;
    public $_removeDocs = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'docBehavior' => array(
                'class' => 'application.behaviors.DocumentsBehavior',
                'docField' => 'data',
                'storagePath' => 'docs/workline',
            ),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->docBehavior->docLabels(),
            array(
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->docBehavior->docRules(),
            array(
            )
        );
    }

    protected function afterDelete()
    {
        $this->docBehavior->docAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->data = json_decode($this->data, true);
        $this->docBehavior->docAfterFind();
        return parent::afterFind();
    }

    protected function beforeSave()
    {
        $this->data = json_encode($this->data);
        return parent::beforeSave();
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }
}
