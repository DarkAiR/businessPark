<?php

class ProjectsOnMainWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $works = $this->getWorks();
        $this->render('projectsOnMain', array(
            'bigWork' => $this->getBigWork(),
            'works' => $works,
        ));
    }

    /**
     Получить список работ
     */
    private function getWorks()
    {
        $arr = array();
        $works = Projects::model()->onSite()->byLimit(6)->findAll();
        return $works;
    }

    /**
     Получить большую работу
     */
    private function getBigWork()
    {
        $work = Projects::model()->onSite()->withBigImage()->byLimit(1)->findAll();
        if (count($work) > 0)
            return reset($work);
        return false;
    }
}