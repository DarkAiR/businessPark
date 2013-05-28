<?php

class MainMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('mainMenu');
    }
}
