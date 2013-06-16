<?php

class OurProjectsWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('ourProjects');
    }
}
