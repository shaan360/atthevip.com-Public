<?php
// Sort cache options
$caches = array();
$fastCache = true;

// Sort the type of cache to use
if( function_exists('xcache_isset') )
{
    // Using XCache
    $caches = array( 'class' => 'CXCache' );
}
else
{
    // Using File Cache - fallback
    $caches = array( 'class' => 'CFileCache' );
    $fastCache = false;
}

// Load env config.php
require_once('config.php');

// Required system configuration. There should be no edit performed here.
return array(
        'preload' => array('log', 'session', 'db', 'cache'),
        'basePath' => ROOT_PATH . 'protected/',
        'modules' => array(
                            'admin' => array(
                                                'import' => array(
                                                	'admin.components.*',
                                                	'admin.models.*'
                                                ),
                                                'layout' => 'main'
                                            ),
                            'site' => array(
                                                'import' => array(
                                                	'site.components.*',
                                                	'site.models.*'
                                                ),
                                                'layout' => 'main'
                                            ),
        ),
        'import' => array(
                            'application.components.*',
                            'application.models.*',
                            'application.behaviors.*',
                            'application.extensions.*',
                            'application.widgets.*',
        ),
        'theme' => 'default',
        'name' => 'At The VIP',
        'defaultController' => 'site/index',
        'layout' => 'main',
        'charset'=>'UTF-8',
        'params' => array( 
							'loggedInDays' => 10,
							'default_group' => 'user',
							'facebookappid' => '',
							'facebookapikey' => '',
							'facebookapisecret' => '',
							'emailin' => 'info@domain.com',
							'emailout' => 'info@domain.com',
							'adminThemeUrl' => false, //'http://files.atthevip.com/admin',
							'siteThemeUrl' => false, //'http://files.atthevip.com/default',
							 ),
        'aliases' => array(
                'helpers' => 'application.widgets',
                'widgets' => 'application.widgets',
        ),
        'components' => array(
        		'db' =>  array(
                        'class' => 'CDbConnection',
                        'connectionString' => CONNECTION_STRING,
                        'username' => DB_USER,
                        'password' => DB_PASS,
                        'charset' => 'UTF8',
                        'tablePrefix' => DB_PREFIX,
                        'schemaCacheID' => 'cache',
                        'schemaCachingDuration' => 60 * 60
                ),
                'email' => array(
	                    'class' => 'application.extensions.email.Email',
	                    'view' => 'email',
	                    'viewVars' => array(),
	                    'layout' => 'main',
	            ),
                'format' => array(
                        'class' => 'CFormatter',
              	 ),
              	 'jumploader' => array(
                    'class' => 'ext.jumploader.jumploader',
            	 ),
				'email' => array(
	                    'class' => 'application.extensions.email.Email',
	                    'view' => 'email',
	                    'layout' => 'main',
	            ),
				'errorHandler'=>array(
			            'errorAction'=>'site/error/error',
			    ),
				'settings' => array(
	                    'class' => 'CustomSettings',
	            ),
	            'func' => array(
	                    'class' => 'Functions',
	            ),
				'authManager'=>array(
				            'class'=>'AuthManager',
				            'connectionID'=>'db',
							'itemTable' => 'authitem',
							'itemChildTable' => 'authitemchild',
							'assignmentTable' => 'authassignment',
							'defaultRoles'=>array('guest'),
				),
				'user'  => array(
						'class' => 'CustomWebUser',
						'allowAutoLogin' => true,
						'autoRenewCookie' => true,
				),
                'urlManager' => array(
                        'class' => 'CustomUrlManager',
                        'urlFormat' => 'path',
                        'cacheID' => 'cache',
                        'showScriptName' => false,
                        //'appendParams' => true,
                        'urlSuffix' => ''
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
                    'timeout' => 60 * 60 * 5,
                    'sessionName' => 'SECSESS',

                ),
                'cache' => $caches,
        ),
);