<?php

Yii::import('application.models.Menu');

abstract class MenuWidget extends ExtendedWidget
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
        $items = MenuItem::model()
            ->onSite()
            ->byParent(0)
            ->byMenuId($this->menuId)
            ->orderDefault()
            ->findAll();

        $itemsArr = array();
        foreach ($items as $item)
        {
            $select = false;
            if (strpos($url, trim($item->link, '/')) === 0)
                $select = true;

            $link = (strpos($item->link, 'http://') === 0 || strpos($item->link, 'https://') === 0)
                ? $item->link
                : CHtml::normalizeUrl('/'.$item->link);

            $iconUrl = $item->getIconUrl();

            $itemsArr[] = array(
                'name' => $item->name,
                'link' => $link,
                'select' => $select,
                'iconUrl' => $iconUrl,
            );
        }

        $this->beforeRender($itemsArr);

        $this->render($this->template, array('items'=>$itemsArr));
    }

    protected function beforeRender(&$itemsArr)
    {
    }
}
