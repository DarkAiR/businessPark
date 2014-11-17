<?php

Yii::import('ext.widgets.MenuWidget');

class PageStructureMenuWidget extends MenuWidget
{
    protected $menuId = Menu::PAGE_TOP_STRUCTURE;
    protected $template = 'pageStructureMenu';
}
