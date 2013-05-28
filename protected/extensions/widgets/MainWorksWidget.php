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
     @deprecated
     Получить список страниц
     */
    private function getPages( $works )
    {
        $picsOnFirstPage = 1;
        $picsOnPage = 6;
        
        if (count($works) <= $picsOnFirstPage)
            return 1;
        return 1 + ceil((count($works)-$picsOnFirstPage) / $picsOnPage);
    }

    /**
     Получить список работ
     */
    private function getWorks()
    {
        $arr = array(
            array( 'id'=>1, 'image'=>'store/projects/project-main.jpg' ),
            array( 'id'=>2, 'image'=>'store/projects/project-4.jpg' ),
            array( 'id'=>3, 'image'=>'store/projects/project-5.jpg' ),
            array( 'id'=>4, 'image'=>'store/projects/project-6.jpg' ),
            array( 'id'=>5, 'image'=>'store/projects/project-7.jpg' ),

            array( 'id'=>6, 'image'=>'store/projects/project-6.jpg' ),
            array( 'id'=>7, 'image'=>'store/projects/project-7.jpg' ),
            array( 'id'=>8, 'image'=>'store/projects/project-5.jpg' ),
            array( 'id'=>9, 'image'=>'store/projects/project-4.jpg' ),
            array( 'id'=>10, 'image'=>'store/projects/project-6.jpg' ),
            array( 'id'=>11, 'image'=>'store/projects/project-4.jpg' ),
            array( 'id'=>12, 'image'=>'store/projects/project-5.jpg' ),
            array( 'id'=>13, 'image'=>'store/projects/project-7.jpg' ),
            array( 'id'=>14, 'image'=>'store/projects/project-6.jpg' ),
            array( 'id'=>15, 'image'=>'store/projects/project-7.jpg' ),
            array( 'id'=>16, 'image'=>'store/projects/project-5.jpg' ),
            array( 'id'=>17, 'image'=>'store/projects/project-4.jpg' ),
            array( 'id'=>18, 'image'=>'store/projects/project-6.jpg' ),
            array( 'id'=>19, 'image'=>'store/projects/project-4.jpg' ),
            array( 'id'=>20, 'image'=>'store/projects/project-5.jpg' ),
            array( 'id'=>21, 'image'=>'store/projects/project-7.jpg' ),
        );
        return array_slice($arr, 0, 1+6+6);
    }
}
