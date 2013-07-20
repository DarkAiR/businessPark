<?php

class MainMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $items = MenuItem::model()->onSite()->byParent(0)->orderDefault()->findAll();
        $this->render('mainMenu', array('items'=>$items));
    }
}
