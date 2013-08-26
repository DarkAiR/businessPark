<?php

class DateHelper
{
    public static function getMonthNameByTimestamp($ts, $index=1)
    {
        static $monthNames = array(
            1 => array('январь', 'января'),
            2 => array('февраль', 'февраля'),
            3 => array('март', 'марта'),
            4 => array('апрель', 'апреля'),
            5 => array('май', 'мая'),
            6 => array('июнь', 'июня'),
            7 => array('июль', 'июля'),
            8 => array('август', 'августа'),
            9 => array('сентябрь', 'сентября'),
            10 => array('октябрь', 'октября'),
            11 => array('ноябрь', 'ноября'),
            12 => array('декабрь', 'декабря'),
        );
        return $monthNames[ date('n', $ts) ][$index];
    }
}