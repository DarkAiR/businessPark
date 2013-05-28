<?php

class ExtendedWebApplication extends CWebApplication
{
	const BLANK_TEMPLATE_NAME = 'blank';
	const USER_ID_COOKIE_NAME = 'authorizedUserId';

	/*public static function arrayToLowerCallback(&$value, &$key)
	{
		$value = strtolower($value);
	}*/

	/*public function createController($route,$owner=null)
	{
		if(($ca=parent::createController($route, $owner))!==null)
		{
			$request = $this->getRequest();
			$pathInfo=urldecode($request->getPathInfo());
			$pathInfo = ltrim($pathInfo,'/');
			$hostInfo = $request->getHostInfo();
		   	$pathInfo = (!empty($pathInfo) ? '/' : '') . $pathInfo . (!empty($pathInfo) ? '/' : '');
			list($controller,$actionID)=$ca;

			$currentUrl = $hostInfo.$pathInfo;
			list($customHeadCaption, $customHeadUrl) = AdminHelper::getCustomHeadCaption($currentUrl);
			if ( $customHeadCaption  != null ) {
				$controller->setHeadTitle($customHeadCaption);
				$controller->setHeadTitleLink($customHeadUrl);
			}
			if ( ( $urlMapping=CustomUrlTitle::model()->findAll(new CDbCriteria(array('condition' => 'url LIKE :matchUrl', 'params'=> array(':matchUrl'=> $pathInfo), 'order' => 'orderNum')) ) )!==null )
			{
				foreach ($urlMapping as $url)
				{
					if (!$url->_gets || ($url->_gets && sizeof((array_intersect($url->_gets, $_GET))) == sizeof($url->_gets)))
					{
						$controller->pageTitle = $url->title;

						if ($controller instanceof ExtendedController)
						{
							$controller->isCustomPageTitle = true;
							$controller->_pageDescription = $url->description;
							$controller->_pageKeywords = $url->keywords;
						}

						return array($controller, $actionID);
					}
				}

				return $ca;
			}
		}

		return $ca;
	}*/

	/*protected function init()
	{
		// Locale check
		$lc = setlocale(LC_ALL,'0');
		preg_match('@(utf-?8)@i',$lc, $matches);
		if(empty($matches)) {
			$descriptors = array(
				array( 'pipe', 'r' ),
				array( 'pipe', 'w' ),
				array( 'pipe', 'w' ),
			);
			$process = proc_open( 'locale -a', $descriptors, $pipes );
			fclose( $pipes[0] );

			$output = stream_get_contents( $pipes[1] );
			fclose( $pipes[1] );
			proc_close( $process );

			preg_match('@ru_RU\.utf-?8@i',$output,$matches);
			if(!empty($matches))
				setlocale(LC_ALL,'ru_RU.UTF-8');
			else {
				preg_match('@([a-zA-Z_]*\.)(utf)-?(8)@i',$output,$matches);
				if(!empty($matches)) {
					setlocale(LC_ALL,$matches[1].strtoupper($matches[2].'-'.$matches[3]));
				} else {
					throw new CHttpException(500,'Locale error.');
				}
			}
		} else {
			setlocale(LC_ALL,'ru_RU.UTF-8');
		}

		// load params from db
		$configitems = LocalConfigItem::model()->byModule('')->findAll();
		$userFilesManager = Yii::app()->getComponent('userFilesManager');

		foreach($configitems as $item)
		{
			if($item->type == LocalConfigItem::TYPE_FILE)
			{
				if($item->id == 'watermark' && $item->value != $item->example)
					$item->value = $userFilesManager->getFileByUid($item->value)->getFileRealPath();
				else
					$item->value = $userFilesManager->getUrlByFileUid($item->value);
			}
		}
		$configitems = CHtml::listData($configitems, 'id', 'value');
		$params = Yii::app()->params->toArray();
		$params = array_merge($params, $configitems);
		$params['interfaceResourcesUrl2'].='/'.require(Yii::app()->params['initializedDataPath'].'/deploykey.php');
		Yii::app()->params->copyFrom($params);

		if(!headers_sent() && (!defined('NO-X-FRAME-HEADER')))
		{
			header('X-Frame-Options: SAMEORIGIN');
		}
		if (isset($_COOKIE['mobileVersion']) && $_COOKIE['mobileVersion']=='true')
			Yii::app()->theme = 'mobile';
		elseif(!isset($_COOKIE['mobileVersion']))
		{
			$detector = Yii::app()->detector;
			if($detector->isMobile()) {
				setcookie('mobileVersion','true',null,'/',Yii::app()->params['cookieDomain']);
				Yii::app()->theme = 'mobile';
			}
		}
		parent::init();
	}*/
}