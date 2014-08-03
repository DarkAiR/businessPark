<?php

class CompanyMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $url = trim( Yii::app()->request->url, '/' );
        $itemsArr = array();
        $hasSelect = false;

        $items = MenuItem::model()->onSite()->orderDefault()->byParent(0)->byMenuId(Menu::COMPANY_MENU)->findAll();
        $itemsArr = array();
        foreach ($items as $item)
        {
            $select = false;
            if (strpos($url, trim($item->link, '/')) === 0)
                $select = true;
            $itemsArr[] = array(
                'name' => $item->name,
                'link' => '/'.trim($item->link,'/'),
                'select' => $select,
            );
        }
        $this->render('companyMenu', array('items'=>$itemsArr));
    }
}