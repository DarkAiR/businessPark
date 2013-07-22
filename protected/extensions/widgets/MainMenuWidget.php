<?php

class MainMenuWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $url = trim( Yii::app()->request->url, '/' );
        $items = MenuItem::model()->onSite()->byParent(0)->orderDefault()->findAll();
        $itemsArr = array();
        $hasSelect = false;
        foreach ($items as $item)
        {
            $select = false;
            if (strpos($url, trim($item->link, '/')) === 0)
            {
                $select = true;
                $hasSelect = true;
            }
            $itemsArr[] = array(
                'name' => $item->name,
                'link' => $item->link,
                'select' => $select,
            );
        }

        $this->render('mainMenu', array('items'=>$itemsArr, 'hasSelect'=>$hasSelect));
    }
}
