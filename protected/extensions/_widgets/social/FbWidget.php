<?php

class FbWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    public $body = false;

    public function run()
    {
        if ($this->body)
            $this->render('fbBody');
        else
            $this->render('fbHead');
    }
}