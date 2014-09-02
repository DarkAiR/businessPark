<?php

/**
 * Резиденты
 */
class Residents extends CActiveRecord
{
    const IMAGE_SMALL_W = 130;
    const IMAGE_SMALL_H = 87;

    public $_image = null; //UploadedFile[]
    public $_removeImageFlag = false; // bool


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'residents',
//                'imageWidth' => self::IMAGE_SMALL_W,
//                'imageHeight' => self::IMAGE_SMALL_H,
                'imageField' => 'image',
            ),
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
            $this->imageBehavior->imageLabels(),
            $this->orderBehavior->orderLabels(),
            array(
                'name'          => 'Название',
                'desc'          => 'Описание',
                'site'          => 'Сайт',
                'phones'        => 'Телефоны',
                'visible'       => 'Показывать',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            $this->orderBehavior->orderRules(),
            array(
                array('name, desc, phones', 'safe'),
                array('name', 'required'),
                array('visible', 'boolean'),
                array('site', 'url'),
            )
        );
    }

    /*
     Отмечаем значком "required"
     */
    public function isAttributeRequired($attribute)
    {
        if (in_array($attribute, array('_image')))
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
                'order' => $alias.'.orderNum ASC',
            ),
        );
    }

    public function byLimit($limit)
    {
        $this->getDbCriteria()->mergeWith(array(
            'limit' => $limit,
        ));
        return $this;
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
                    'visible' => CSort::SORT_DESC,
                )
            )
        ));
    }

    public function getImageUrl()
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
