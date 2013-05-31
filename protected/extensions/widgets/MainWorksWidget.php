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
            array( 'id'=>1, 'image'=>'store/projects/project-main.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>2, 'image'=>'store/projects/project-4.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>3, 'image'=>'store/projects/project-5.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>4, 'image'=>'store/projects/project-6.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>5, 'image'=>'store/projects/project-7.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),

            array( 'id'=>6, 'image'=>'store/projects/project-6.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>7, 'image'=>'store/projects/project-7.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>8, 'image'=>'store/projects/project-5.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>9, 'image'=>'store/projects/project-4.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>10, 'image'=>'store/projects/project-6.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>11, 'image'=>'store/projects/project-4.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>12, 'image'=>'store/projects/project-5.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>13, 'image'=>'store/projects/project-7.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>14, 'image'=>'store/projects/project-6.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>15, 'image'=>'store/projects/project-7.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>16, 'image'=>'store/projects/project-5.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>17, 'image'=>'store/projects/project-4.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>18, 'image'=>'store/projects/project-6.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>19, 'image'=>'store/projects/project-4.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>20, 'image'=>'store/projects/project-5.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
            array( 'id'=>21, 'image'=>'store/projects/project-7.jpg', 'title'=>'Заголовок', 'desc'=>'Описание', 'link'=>'/link' ),
        );
        return array_slice($arr, 0, 1+6+6);
    }
}
