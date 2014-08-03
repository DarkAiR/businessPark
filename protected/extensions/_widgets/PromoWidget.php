<?php

class PromoWidget extends ExtendedWidget
{
    public $model;
    public $attribute;

    public function run()
    {
    	$promo = Promo::model()->findByPk(Promo::DEFAULT_ID);
        $this->render('promo', array(
        	'promo' => $promo
        ));
    }
}
