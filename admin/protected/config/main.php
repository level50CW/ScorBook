<?php

ob_start();
 
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Northwoods',
	
	'theme'=>'green',

	// preloading 'log' component
	'preload'=>array('bootstrap','log'),

	// autoloading mfodel and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345678',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		/*'db'=>array(
            'connectionString' => 'mysql:host=mysql51-109.wc1.ord1.stabletransit.com;dbname=827572_nwapp',
            'emulatePrepare' => true,
            'username' => '827572_appuser',
            'password' => 'Uhj%sDg89',
            'charset' => 'utf8',
		),*/
		'simpleImage'=>array(
                        'class' => 'application.extensions.CSimpleImage',
        ),
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=northwoods',
			'emulatePrepare' => true,
			'username' => 'northwoods',
			'password' => '%north2014',
			'charset' => 'utf8',
		),

       /* 'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=827572_nwapp',
            'emulatePrepare' => true,
            'username' => 'nwapi',
            'password' => 'Uhj%sDg89',
            'charset' => 'utf8',
        ),*/
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
			        'class'=>'CWebLogRoute',  'levels'=>'trace, info, error, warning',
			    ),
			    array(
			        'class'=>'CFileLogRoute',  'levels'=>'trace, info, error, warning',
			    ),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'admin@northwoods.com',
	),
);