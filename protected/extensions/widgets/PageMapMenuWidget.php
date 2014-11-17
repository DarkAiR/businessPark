<?php

Yii::import('ext.widgets.MenuWidget');

class PageMapMenuWidget extends MenuWidget
{
    protected $menuId = Menu::PAGE_TOP_MAP;
    protected $template = 'pageMapMenu';
}
