<?php

/**
 * Проект
 */
class Persons extends CActiveRecord
{
    const IMAGE_WIDTH = 72;        // 18px * 4
    const IMAGE_HEIGHT = 72;       // 18px * 4

    const IMAGE_BIG_WIDTH = 198;    // 18px * 11
    const IMAGE_BIG_HEIGHT = 198;   // 18px * 11

    public $_photo = null; //UploadedFile[]
    public $_removePhotoFlag = false; // bool

    public $_photoBig = null; //UploadedFile[]
    public $_removePhotoBigFlag = false; // bool


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
                'storagePath' => 'persons',
                'imageWidth' => self::IMAGE_WIDTH,
                'imageHeight' => self::IMAGE_HEIGHT,
                'imageField' => 'photo',
                'imageLabel' => 'Маленькое фото',
                'innerImageField' => '_photo',
                'innerRemoveBtnField' => '_removePhotoFlag',
            ),
            'imageBigBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'persons/big',
                'imageWidth' => self::IMAGE_BIG_WIDTH,
                'imageHeight' => self::IMAGE_BIG_HEIGHT,
                'imageField' => 'photoBig',
                'imageLabel' => 'Большое фото',
                'innerImageField' => '_photoBig',
                'innerRemoveBtnField' => '_removePhotoBigFlag',
            ),
        );
    }

    public function relations()
    {
        return array(
            'projects' => array(self::MANY_MANY, 'Projects', 'Person2Project(personId, projectId)'),
        );
    }

    public function attributeLabels()
    {
        return array_merge(
            $this->imageBehavior->imageLabels(),
            $this->imageBigBehavior->imageLabels(),
            array(
                'name' => 'Имя',
                'position' => 'Должность',
                'projects' => 'Проекты',
                'visible' => 'Показывать',
                'orderNum' => 'Порядок сортировки',
            )
        );
    }

    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            $this->imageBigBehavior->imageRules(),
            array(
                array('name, position, projects', 'safe'),
                array('name', 'required'),
                array('visible', 'boolean'),
                array('orderNum', 'numerical', 'integerOnly'=>true),
            )
        );
    }

    /*
     Отмечаем значком "required"
     */
    public function isAttributeRequired($attribute)
    {
        /*if (in_array($attribute, array('_photo', '_photoBig')))
            return true;*/
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
        ));
    }

    public function getPhotoUrl()
    {
        return $this->imageBehavior->getImageUrl();
    }

    public function getPhotoBigUrl()
    {
        return $this->imageBigBehavior->getImageUrl();
    }

    protected function afterDelete()
    {
        $this->imageBehavior->imageAfterDelete();
        $this->imageBigBehavior->imageAfterDelete();

        $sql = Yii::app()->db->commandBuilder;
        $sql->createSqlCommand('DELETE FROM `Person2Project` WHERE `personId` = ' . $this->id)->execute();

        return parent::afterDelete();
    }

    protected function afterFind()
    {
        $this->imageBehavior->imageAfterFind();
        $this->imageBigBehavior->imageAfterFind();
        return parent::afterFind();
    }
}
