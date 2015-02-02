<?php

class FooterMainPageWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
        $this->render('footerMainPage', array(
            'mainPhones' => implode('<br/>', Yii::app()->localConfig->getConfig('contact-info.mainPhones', true)),
            'email' => Yii::app()->localConfig->getConfig('contact-info.email'),
        ));
    }
}
