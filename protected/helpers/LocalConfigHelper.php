<?php

class LocalConfigHelper
{
    /**
     * Replace shortcuts to local config params
     */
    public static function parseText($text)
    {
        $search = array(
            '%MAIN_PHONES%',
            '%MAIN_PHONE%',
            '%SALE_PHONES%',
            '%SALE_PHONE%',
            '%EMAIL%',
            '%CITY%',
            '%ADDRESS%',
            '%OFFICE%',
        );
        $replace = array(
            implode(', ', Yii::app()->localConfig->getConfig('contact-info.mainPhones')),
            array_shift(Yii::app()->localConfig->getConfig('contact-info.mainPhones')),
            implode(', ', Yii::app()->localConfig->getConfig('contact-info.salePhones')),
            array_shift(Yii::app()->localConfig->getConfig('contact-info.salePhones')),
            Yii::app()->localConfig->getConfig('contact-info.email'),
            Yii::app()->localConfig->getConfig('contact-info.city'),
            Yii::app()->localConfig->getConfig('contact-info.address'),
            Yii::app()->localConfig->getConfig('contact-info.office'),
        );
        return str_replace($search, $replace, $text);
    }
}
