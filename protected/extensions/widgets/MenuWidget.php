<?php

Yii::import('application.models.Menu');

class MenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    protected $menuId = Menu::NONE;
    protected $template = '';

    public function run()
    {
        if (empty($this->template))
            return;

        $url = trim( Yii::app()->request->url, '/' );
        $items = MenuItem::model()->onSite()->byParent(0)->byMenuId($this->menuId)->orderDefault()->findAll();
        $itemsArr = array();
        foreach ($items as $item)
        {
            $select = false;
            if (strpos($url, trim($item->link, '/')) === 0)
                $select = true;
            $itemsArr[] = array(
                'name' => $item->name,
                'link' => $item->link,
                'select' => $select,
            );
        }

        $this->render($this->template, array('items'=>$itemsArr));
    }
}
