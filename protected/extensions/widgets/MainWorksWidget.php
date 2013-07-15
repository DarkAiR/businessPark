<?php

class MainWorksWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $works = $this->getWorks();
        $this->render('mainWorks', array(
            'works' => $works,
            'currPage' => 1,
        ));
    }

    /**
     Получить список работ
     */
    private function getWorks()
    {
        $arr = array();
        $works = MainWorkItem::model()->onSite()->orderDefault()->findAll();
        foreach ($works as &$work)
        {
            $arr[] = array(
                'id' => $work->id,
                'image' => $work->getImageUrl(),
                'title' => $work->title,
                'desc' => $work->descCorrect,
                'link' => ''
            );
        }
        return $arr;
    }
}
