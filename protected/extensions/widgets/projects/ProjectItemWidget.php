<?php

class ProjectItemWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    
    public $project;
    public $showDate = true;

    public function run()
    {
        $this->render('projectItem', array(
            'project' => $this->project,
            'showDate' => $this->showDate,
        ));
    }
}