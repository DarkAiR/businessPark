<?php

class ProjectsOwnWidget extends ExtendedWidget
{
    const LIMIT = 3;

    public $model;
    public $attribute;

    public function run()
    {
        $works = $this->getWorks();
        $this->render('projectsOwn', array(
            'works' => $works,
        ));
    }

    /**
     Получить список собственных проектов
     */
    private function getWorks()
    {
        $arr = array();
        $works = ProjectsOwn::model()->onSite()->byLimit(self::LIMIT)->findAll();
        foreach ($works as &$work)
        {
            $arr2 = array(
                'id' => $work->id,
                'desc' => $work->desc,
                'image' => $work->getImageUrl(),
            );
            $arr[] = $arr2;
        }
        if (count($arr) < self::LIMIT)
        {
            for ($i=count($arr); $i < self::LIMIT; $i++)
                $arr[] = array();
        }
        return $arr;
    }
}
