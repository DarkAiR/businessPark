<?php

$params = require(dirname(__FILE__) . '/../protected/config/params.php');
defined('YII_DEBUG') or define('YII_DEBUG', $params['yiiDebug']);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
define('PUBLISH_BOOTSTRAP', false);

$yii = dirname(__FILE__) . '/../lib/yii/framework/' . (YII_DEBUG ? 'yii.php' : 'yiilite.php');
$config = dirname(__FILE__) . '/../protected/config/main.php';

require_once($yii);
Yii::createWebApplication($config)->run();
//require(dirname(__FILE__) . '/protected/components/ExtendedWebApplication.php');
//Yii::createApplication('ExtendedWebApplication', $config)->run();
