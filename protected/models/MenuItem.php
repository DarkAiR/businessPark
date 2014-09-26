<?php

class MenuItem extends CActiveRecord
{
    const IMAGE_W = 28;
    const IMAGE_H = 28;

    public $_image = null; //UploadedFile[]
    public $_removeImageFlag = false; // bool


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'manyToMany' => array(
                'class' => 'lib.ar-relation-behavior.EActiveRecordRelationBehavior',
            ),
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'menu',
                'imageWidth' => self::IMAGE_W,
                'imageHeight' => self::IMAGE_H,
                'imageField' => 'image',
                'imageLabel' => 'Иконка'
            ),
            'orderBehavior' => array(
                'class' => 'application.behaviors.OrderBehavior',
            ),
        );
    }

    public function relations()
    {
        return array(
            'children' => array(self::HAS_MANY, 'MenuItem', 'parentItemId', 'order'=>'children.orderNum ASC'),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->imageBehavior->imageLabels(),
            $this->orderBehavior->orderLabels(),
            array(
                'menuId' => 'Меню',
                'parentItemId' => 'Родительский раздел',
                'visible' => 'Показывать',
                'link' => 'Ссылка',
                'name' => 'Текст',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            $this->orderBehavior->orderRules(),
            array(
                array('menuId, name, link', 'required'),
                array('visible', 'boolean'),
                array('orderNum, parentItemId', 'numerical', 'integerOnly'=>true),
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
                'order' => $alias.'.menuId ASC, '.$alias.'.parentItemId ASC, '.$alias.'.orderNum ASC',
            ),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize'=>20,
            ),
            'sort' => array(
                'defaultOrder' => array(
                    'menuId' => CSort::SORT_ASC,
                    'orderNum' => CSort::SORT_ASC,
                )
            )
        ));
    }


    public function byParent($parent)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.parentItemId = '.$parent,
        ));
        return $this;
    }

    public function byMenuId($menuId)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.menuId = '.$menuId,
        ));
        return $this;
    }

    public function getIconUrl()
    {
        return $this->imageBehavior->getImageUrl();
    }

    protected function afterDelete()
    {
        $this->imageBehavior->imageAfterDelete();
        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->imageBehavior->imageAfterFind();
        return parent::afterFind();
    }

    public function beforeSave()
    {
        $this->orderBehavior->orderBeforeSave();
        return parent::beforeSave();
    }
}
