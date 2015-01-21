<?php

/**
 * Панорамы
 */
class Panorama extends CActiveRecord
{
    public $_swf = null;
    public $_removeSwf = false;

    public $_mov = null;
    public $_removeMov = false;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'flashBehavior' => array(
                'class' => 'application.behaviors.FlashBehavior',
                'storagePath' => 'panorama',
                'flashField' => 'swf',
                'innerField' => '_swf',
                'innerRemoveBtnField' => '_removeSwf'
            ),
            'videoBehavior' => array(
                'class' => 'application.behaviors.FlashBehavior',
                'storagePath' => 'panorama',
                'flashField' => 'mov',
                'innerField' => '_mov',
                'innerRemoveBtnField' => '_removeMov'
            ),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->videoBehavior->flashLabels(),
            $this->flashBehavior->flashLabels(),
            array(
                'createDate'    => 'Дата',
                'visible'       => 'Показывать',
            )
        );
    }    

    public function rules()
    {
        return array_merge(
            $this->videoBehavior->flashRules(),
            $this->flashBehavior->flashRules(),
            array(
                array('createDate', 'required'),
                array('createDate', 'date', 'allowEmpty'=>false, 'format'=>'yyyy-MM-dd'),
                array('visible', 'boolean'),
                array('_swf', 'requiredValidator'),
            )
        );
    }

    public function requiredValidator($attribute, $params)
    {
        $value = $this->_swf;
        $isEmptyInnerFlash = ($value===null || $value===array() || $value==='');

        $value = $this->swf;
        $isEmptyFlash = ($value===null || $value===array() || $value==='');

        if ($isEmptyInnerFlash && $isEmptyFlash) {
            $message = Yii::t('yii','{attribute} cannot be blank.');
            $params['{attribute}'] = $this->getAttributeLabel('_swf');
            $this->addError('_swf', strtr($message,$params));
        }
    }

    /*
     Отмечаем значком "required"
     */
    public function isAttributeRequired($attribute)
    {
        if (in_array($attribute, array('_swf')))
            return true;
        return parent::isAttributeRequired($attribute);
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

    public function getVideoUrl()
    {
        return $this->videoBehavior->getFlashUrl();
    }

    public function getFlashUrl()
    {
        return $this->flashBehavior->getFlashUrl();
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

    protected function afterDelete()
    {
        $this->videoBehavior->flashAfterDelete();
        $this->flashBehavior->flashAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->videoBehavior->flashAfterFind();
        $this->flashBehavior->flashAfterFind();
        return parent::afterFind();
    }
}
