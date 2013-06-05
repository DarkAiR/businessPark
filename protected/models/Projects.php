<?php

/**
 * @property int id
 * @property string title
 * @property string desc
 * @property string text
 * @property string link
 * @property string image
 * @property string bigImage
 * @property int sectionId
 */
class Projects extends CActiveRecord
{
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
        );
    }

    public function relations()
    {
        return array(
            'section' => array(self::BELONGS_TO, 'ProjectSections', 'sectionId'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Заголовок',
            'desc' => 'Краткое описание для отображения на самом изображении',
            'text' => 'Описание',
            'link' => 'Ссылка на сайт',
            'image' => 'Главная картинка',
            'bigImage' => 'Большая картинка',
            'section' => 'Раздел'            
        );
    }

    public function rules()
    {
        return array(
            array('title, desc, image, sectionId', 'required'),
            array('title, desc, text, link, image, bigImage, sectionId', 'safe', 'on' => 'search'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        //$criteria->compare('email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
