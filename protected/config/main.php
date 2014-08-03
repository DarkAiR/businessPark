<?php

Yii::setPathOfAlias('lib', realpath(__DIR__ . '/../../lib'));

$params = require 'params.php';
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => $params['appName'],
    'language' => 'ru',
    'preload' => array('log'),
    'import' => array(
        'application.models.*',
        'application.models.forms.*',
        'application.components.*',
        'application.helpers.*',
        'lib.CurlHelper.*',
        'lib.ImageHelper.*',
        'ext.mAdmin.*',
    ),
    'modules' => array(
        'system2',
//        'company',
//        'projects',
        'sitemenu',
//        'news',
        'contentBlocks',
//        'articles',
//        'persons',
//        'vacancy',
//        'promo'
    ),
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('site/login'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'urlSuffix' => '/',
            'showScriptName' => false,
            'rules' => array(
                '/'                                 => 'site/index',
                'uploadImage'                       => 'site/uploadImage',
                'uploadFile'                        => 'site/uploadFile',

                // News
//                'news/show/<id:\d+>/'               => 'news/news/show',
//                'news/<year:\d+>/'                  => 'news/news/index',
//                'news/'                             => 'news/news/index',

                // Projects
//                'works/show/<id:\d+>/'              => 'projects/projects/show',
//                'works/<sectionId:\d+>/'            => 'projects/projects/index',
//                'works/'                            => 'projects/projects/index',

                // Service
//                'service/'                          => 'projects/projectSections/index',

                // Vacancy
//                'company/vacancy/<id:\d+>/'         => 'vacancy/vacancy/show',
//                'company/vacancy/<action:\w+>/'     => 'vacancy/vacancy/<action>',
//                'company/vacancy/'                  => 'vacancy/vacancy/index',

                // Company
//                'company/'                          => 'company/company/index',
//                'company/<action:\w+>/'             => 'company/company/<action>',

                // Admin
                'admin/'                            => 'system2',
                'admin/<module:\w+>/'               => '<module>',
                'admin/<module:\w+>/<controller:\w+>/' => '<module>/admin<controller>',
                'admin/<module:\w+>/<controller:\w+>/<action:\w+>/' => '<module>/admin<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=' . $params['dbHost'] . ';dbname=' . $params['dbName'],
            'emulatePrepare' => true,
            'username' => $params['dbLogin'],
            'password' => $params['dbPassword'],
            'charset' => 'utf8',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'fs' => array(
            'class' => 'FileSystem',
            'nestedFolders' => 1,
        ),
        'viewRenderer' => array(
            'class' => 'lib.twig-renderer.ETwigViewRenderer',
            'twigPathAlias' => 'lib.twig.lib.Twig',
            'options' => array(
                'autoescape' => true,
            ),
            'functions' => array(
                'widget' => array(
                    0 => 'TwigFunctions::widget',
                    1 => array('is_safe' => array('html')),
                ),
                'const' => 'TwigFunctions::constGet',
                'static' => 'TwigFunctions::staticCall',
                'import' => 'TwigFunctions::importResource',
                'absLink' => 'TwigFunctions::absLink',
                'plural' => 'TwigFunctions::plural',
            ),
            'filters' => array(
                'unset' => 'TwigFunctions::filterUnset',
                'date' => 'TwigFunctions::filterDate',
            ),
        ),
        'bootstrap' => array(
            'class' => 'lib.booster.components.Bootstrap',
            'responsiveCss' => true,
            'jqueryCss' => false,
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'image' => array(
            'class' => 'ext.image.CImageComponent',
            'driver' => $params['imageDriver'],
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*array(
                    'class'=>'CWebLogRoute',
                ),*/
            ),
        ),
        'localConfig' => array(
            'class' => 'ext.localConfig.LocalConfigExtension'
        ),
    ),
    'params' => array_merge(
        $params,
        array(
            'md5Salt' => 'ThisIsMymd5Salt(*&^%$#',
        )
    ),
);
