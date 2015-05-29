<?php
include_once('opt_tng/start.php');
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
if ( getenv('REQUEST_URI') == '/index.php' )
{
    Header( "HTTP/1.0 301 Moved Permanently" );
    Header( "Location: http://{$_SERVER['HTTP_HOST']}{$location}" );
    exit;
}

if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
    header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
    exit;
}
if ($_SERVER['REQUEST_URI'] != '/' && substr($_SERVER['REQUEST_URI'], -1) != '/') {
	$location = $_SERVER['REQUEST_URI'];
	header("HTTP/1.0 301 Moved Permanently");
	header("Location: http://{$_SERVER['HTTP_HOST']}{$location}/");
	header("Connection: close");
	exit();
}
include_once('opt_tng/finish.php');