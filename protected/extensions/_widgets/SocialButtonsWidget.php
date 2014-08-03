<?php

class SocialButtonsWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('socialButtons');
    }
}
