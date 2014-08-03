<?php

class SocialLikeButtonsWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('socialLikeButtons');
    }
}