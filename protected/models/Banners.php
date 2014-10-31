<?php

/**
 * Баннеры
 */
class Banners extends CActiveRecord
{
    const IMAGE_W = 697;
    const IMAGE_H = 44;

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
                'storagePath' => 'banners',
                'imageMaxWidth' => self::IMAGE_W,
                'imageHeight' => self::IMAGE_H,
                'imageField' => 'image',
            ),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->imageBehavior->imageLabels(),
            array(
                'name' => 'Название',
                'link' => 'Ссылка',
                'visible' => 'Показывать',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            array(
                array('name', 'required'),
                array('name, link', 'safe'),
                array('visible', 'boolean'),
                array('_image', 'requiredImageValidator'),
            )
        );
    }

    public function requiredImageValidator($attribute,$params)
    {
        $value = $this->$attribute;
        $isEmpty = ($value===null || $value===array() || $value==='');

        $value = $this->image;
        $isEmptyImage = ($value===null || $value===array() || $value==='');

        if ($isEmpty && $isEmptyImage) {
            $message = Yii::t('yii','{attribute} cannot be blank.');
            $params['{attribute}'] = $this->getAttributeLabel($attribute);
            $this->addError($attribute, strtr($message,$params));
        }
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
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => array(
                    'id' => CSort::SORT_DESC,
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
}
