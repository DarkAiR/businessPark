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
        $arr = array(
            array( 'id'=>1, 'image'=>'store/projects/project-1.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link1' ),
            array( 'id'=>2, 'image'=>'store/projects/project-2.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link2' ),
            array( 'id'=>3, 'image'=>'store/projects/project-1.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link1' ),
        );
        return $arr;
    }
}
