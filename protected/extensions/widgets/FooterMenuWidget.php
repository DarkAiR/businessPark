<?php

Yii::import('ext.widgets.MenuWidget');

class FooterMenuWidget extends MenuWidget
{
    protected $menuId = Menu::FOOTER_MENU;
    protected $template = 'footerMenu';
}
