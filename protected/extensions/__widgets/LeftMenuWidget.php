<?php

Yii::import('ext.widgets.MenuWidget');

class LeftMenuWidget extends MenuWidget
{
    public $menuId = Menu::LEFT_MENU_MAIN;
    protected $template = 'leftMenu';

    protected function beforeRender(&$itemsArr)
    {
        foreach ($itemsArr as &$item) {
            $arr = explode(' ', $item['name']);
            $item['name'] = implode('<br/>', $arr);
        }
    }
}
