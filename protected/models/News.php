<?php

/**
 * Новость
 */
class News extends CActiveRecord
{
    const IMAGE_SMALL_W = 130;
    const IMAGE_SMALL_H = 87;

    // Маленькая картинка в ленте на главной странице
    const IMAGE_SMALL_MAIN_W = 115;

    public $_image = null; //UploadedFile[]
    public $_removeImageFlag = false; // bool

    public $createTimeDate = '';
    public $createTimeTime = '';


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            // 'manyToMany' => array(
            //     'class' => 'lib.ar-relation-behavior.EActiveRecordRelationBehavior',
            // ),
            'imageBehavior' => array(
                'class' => 'application.behaviors.ImageBehavior',
                'storagePath' => 'news',
//                'imageWidth' => self::IMAGE_SMALL_W,
//                'imageHeight' => self::IMAGE_SMALL_H,
                'imageField' => 'image',
                'imageLabel' => 'Маленькая картинка',
            ),
            'timeBehavior' => array(
                'class' => 'application.behaviors.TimeBehavior',
                'createTimeField' => 'createTime',
            )
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
            $this->timeLabels(),
            array(
                'title' => 'Заголовок',
                'shortDesc' => 'Короткое описание',
                'desc' => 'Текст',
                'onMain' => 'Показывать на главной',
                'visible' => 'Показывать',
                'newsLink' => 'Ссылка на новость',
                'createTimeTime' => 'Время создания',
                'createTimeDate' => 'Дата создания'
            )
        );
    }


    public function rules()
    {
        return array_merge(
            $this->imageBehavior->imageRules(),
            $this->timeRules(),
            array(
                array('title, desc, shortDesc', 'safe'),
                array('onMain, visible', 'boolean'),
                array('createTimeTime, createTimeDate', 'safe'),
                array('title, shortDesc, createTimeTime, createTimeDate', 'required'),
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
            'onMain' => array(
                'condition' => $alias.'.onMain = 1',
            ),
            'orderDefault' => array(
                'order' => $alias.'.createTime DESC',
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


    public function byYear($year)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => "DATE_FORMAT(FROM_UNIXTIME(createTime),'%Y') = :year",
            'params' => array(
                'year' => $year,
            ),
        ));
        return $this;
    }


    public function search()
    {
        $criteria = new CDbCriteria;
        //$criteria->compare('name', $this->name, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => array(
                    'onMain' => CSort::SORT_DESC,
                    'id' => CSort::SORT_DESC,
                )
            )
        ));
    }

    public function getNewsLink()
    {
        return self::getNewsLinkById($this->id);
    }

    public static function getNewsLinkById($id)
    {
        return CHtml::normalizeUrl( array(0=>'/news/news/show', 'id'=>$id) );
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
        $this->timeAfterFind();

        $this->createTimeDate = date('d.m.Y', $this->createTime);
        $this->createTimeTime = date('H:i', $this->createTime);

        return parent::afterFind();
    }

    protected function beforeSave()
    {
        if (!empty($this->createTimeDate) && !empty($this->createTimeTime))
            $this->createTime = strtotime($this->createTimeDate.' '.$this->createTimeTime);

        $this->timeCreate();
        return parent::beforeSave();
    }
}
