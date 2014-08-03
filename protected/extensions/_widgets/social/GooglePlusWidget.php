<?php

class GooglePlusWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    public $body = false;       // for compatible

    public function run()
    {
        $this->render('googlePlusBody');
    }
}