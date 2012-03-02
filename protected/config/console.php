<?php
// Include the config
include('config.php');
// Console configurations
return array(
	'preload' => array('log'),
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	'import' => array(
                            'application.components.*',
                            'application.models.*',
                            'application.extensions.*',
                            'application.widgets.*',
        ),
	'components' => array(
		'func' => array(
                'class' => 'Functions',
        ),
        'settings' => array(
                'class' => 'CustomSettings',
        ),
        'authManager'=>array(
		            'class'=>'AuthManager',
		            'connectionID'=>'db',
					'itemTable' => 'authitem',
					'itemChildTable' => 'authitemchild',
					'assignmentTable' => 'authassignment',
					'defaultRoles'=>array('guest'),
		),
		'request' => array(
                'class' => 'CHttpRequest',
                'enableCookieValidation' => true,
                'enableCsrfValidation' => false,
                'csrfTokenName' => 'SECTOKEN',
        ),
        'session' =>  array(
			'class' => 'CDbHttpSession',
			'sessionTableName' => 'sessions',
			'connectionID' => 'db',
            'timeout' => 3600,
            'sessionName' => 'SECSESS',

        ),
		'log' => array(
                        'class' => 'CLogRouter',
                        'routes' => array(
                                array(
                                        'class'=>'CFileLogRoute',
                                        'logFile' => 'console.log',
                                        'enabled' => true,
										'levels' => 'console',
                                ),						
                        ),
                ),
	   'db' =>  array(
                'class' => 'CDbConnection',
                'connectionString' => CONNECTION_STRING,
                'username' => DB_USER,
                'password' => DB_PASS,
                'charset' => 'UTF8',
                'tablePrefix' => DB_PREFIX,
                'emulatePrepare' => true,
                'enableProfiling' => true,
                //'schemaCacheID' => 'cache',
                //'schemaCachingDuration' => 3600,
        ),
	),
);