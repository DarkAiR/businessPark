<?php

class ProjectsOwnWidget extends ExtendedWidget
{
    const LIMIT = 2;

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
                'title' => '',
                'desc' => $work->desc,
                'image' => $work->getImageUrl(),
                'link' => $work->link
            );
            switch ($work->type)
            {
            	case ProjectsOwn::TYPE_IN_PROGRESS:
            		$arr2['title'] = 'В разработке';
            		break;
            	case ProjectsOwn::TYPE_OWN_PROJECT:
            		$arr2['title'] = 'Собственный проект';
            		break;
            }
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
