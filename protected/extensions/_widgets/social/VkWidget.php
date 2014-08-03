<?php

class VkWidget extends ExtendedWidget
{
    public $model;
    public $attribute;
    public $body = false;

    public function run()
    {
        if ($this->body)
            $this->render('vkBody');
        else
            $this->render('vkHead');
    }
}