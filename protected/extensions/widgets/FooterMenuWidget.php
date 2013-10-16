<?php

Yii::import('ext.widgets.MenuWidget');

class FooterMenuWidget extends MenuWidget
{
    protected $menuId = Menu::FOOTER_MENU;
    protected $template = 'footerMenu';

    public function run()
    {
        if ( strpos(Yii::app()->request->url, '/company/') === 0 )
            return;
        return parent::run();
    }
}
