<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 21.08.13
 * Time: 19:27
 * To change this template use File | Settings | File Templates.
 */

function h1_search($text) {
    $matches = array();
    if(preg_match('@</h1>@si', $text, $matches)) {
        return $matches;
    } else {
        return false;
    }
}

function onBeforeOpt($text) {

    return $text;
}

function onAfterOpt($text) {

    return $text;
}

