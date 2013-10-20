<?php

class MainWorksLentaWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $works = $this->getWorks();
        $this->render('mainWorksLenta', array(
            'works' => $works,
        ));
    }

    /**
     Получить список работ
     */
    private function getWorks()
    {
        $arr = array();
        $works = Projects::model()->onSite()->orderDefault()->byLimit(5)->findAll();
        return $works;
    }
}
