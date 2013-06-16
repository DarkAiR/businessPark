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
        $arr = array(
            array( 'id'=>1, 'image'=>'store/smallProjects/project-1.jpg', 'desc'=>'Сайт "Верона мобили"' ),
            array( 'id'=>2, 'image'=>'store/smallProjects/project-2.jpg', 'desc'=>'Светофор "Кайсериус"' ),
            array( 'id'=>3, 'image'=>'store/smallProjects/project-3.jpg', 'desc'=>'Интранет для оптимизации процессов в "Альфа-банке"' ),
            array( 'id'=>4, 'image'=>'store/smallProjects/project-4.jpg', 'desc'=>'Плакат кинофильма "Отдать концы"' ),
            array( 'id'=>5, 'image'=>'store/smallProjects/project-5.jpg', 'desc'=>'Большие "Графические баннеры" для Альфа-банка' ),
        );
        shuffle($arr);
        return $arr;
    }
}
