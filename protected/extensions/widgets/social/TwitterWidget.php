<?php

class TwitterWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    public $body = false;       // NOTE: for compatible with other widgets

    public function run()
    {
        $this->render('twitterBody');
    }
}