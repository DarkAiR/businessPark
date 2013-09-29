<?php

/**
 * Контентный блок
 */
class ContentBlocks extends CActiveRecord
{
    const POS_NONE = 0;
    const POS_MAIN_LEFT = 1;            // На главной слева
    const POS_MAIN_CENTER = 2;          // На главной в центре
    const POS_MAIN_RIGHT = 3;           // На главной справа
    const POS_FOOTER_WORKTIME = 4;      // В подвале время работы
    const POS_VACANCY_MAIN_TEXT = 101;  // Главный текст на странице вакансий


    private static $posNames = array(
        self::POS_MAIN_LEFT => 'На главной слева',
        self::POS_MAIN_CENTER => 'На главной в центре',
        self::POS_MAIN_RIGHT => 'На главной справа',
        self::POS_FOOTER_WORKTIME => 'Время работы в подвале',
        self::POS_VACANCY_MAIN_TEXT => 'Текст на странице вакансий',
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Заголовок',
            'text' => 'Текст',
            'position' => 'Место размещения',
            'visible' => 'Показывать',
        );
    }

    public function rules()
    {
        return array(
            array('title, text', 'safe'),
            array('visible', 'boolean'),
            array('position', 'numerical', 'integerOnly'=>true),
        );
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

    public function byPosition($pos)
    {
        $alias = $this->getTableAlias();
        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias.'.position = '.$pos,
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

    public function getPosNames()
    {
        return self::$posNames;
    }
}
