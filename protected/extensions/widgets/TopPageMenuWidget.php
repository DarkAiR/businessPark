<?php

Yii::import('ext.widgets.MenuWidget');

class TopPageMenuWidget extends MenuWidget
{
    public $menu = Menu::NONE;
    protected $template = 'topPageMenu';

    public function run()
    {
        $this->menuId = $this->menu;
        parent::run();
    }
}
