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
        $works = Projects::model()->onSite()->byLimit(5)->findAll();
        foreach ($works as &$work)
        {
            $arr[] = array(
                'id' => $work->id,
                'image' => $work->getImageUrl(),
                'desc' => $work->desc,
            );
        }
        return $arr;
    }
}
