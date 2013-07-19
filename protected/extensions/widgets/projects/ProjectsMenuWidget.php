<?php

class ProjectsMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('projectsMenu');
    }
}
