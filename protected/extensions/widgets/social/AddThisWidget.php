<?php

class AddThisWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    public $body = false;       // for compatible

    public function run()
    {
        $this->render('addThisBody');
    }
}