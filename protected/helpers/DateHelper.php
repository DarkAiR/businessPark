<?php

class DateHelper
{
    // Дата для новостей
    public static function formatNewsDate($time)
    {
        return date('j', $time).' '.self::getMonthNameByTimestamp($time, 1);
    }

    /**
     * Дата для панорамы
     */
    public static function formatPanoramsDate($time)
    {
        $time = strtotime($time);
        return self::getMonthNameByTimestamp($time, 0) . ' ' . date('Y', $time);
    }

    /**
     * Дата для группирования панорам
     */
    public static function formatPanoramsGroupDate($time)
    {
        $time = strtotime($time);
        return date('Y-m', $time);
    }

    // Получить русское имя месяца в нужном падеже
    public static function getMonthNameByTimestamp($ts, $index)
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