<?php

class ProjectsOnMainWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $bigWork = $this->getBigWork();
        $works = $this->getWorks($bigWork);
        $this->render('projectsOnMain', array(
            'bigWork' => $bigWork,
            'works' => $works,
        ));
    }

    /**
     Получить список работ
     */
    private function getWorks($bigWork)
    {
        $arr = array();
        $works = Projects::model()->onSite()->orderDefault()->byLimit(7)->findAll();
        if ($bigWork)
        {
            foreach ($works as $k=>$v)
            {
                if ($v->id == $bigWork->id)
                {
                    unset($works[$k]);
                    break;
                }
            }
        }
        $works = array_slice($works, 0, 6);
        return $works;
    }

    /**
     Получить большую работу
     */
    private function getBigWork()
    {
        $work = Projects::model()->onSite()->orderDefault()->withBigImage()->byLimit(1)->findAll();
        if (count($work) > 0)
            return reset($work);
        return false;
    }
}