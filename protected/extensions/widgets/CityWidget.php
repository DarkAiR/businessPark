<?php

class CityWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('city');
    }
}
