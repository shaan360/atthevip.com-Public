<?php

// Load main config file
$main = require_once( 'main.php' );

// Development configurations
$development = array(
    'components' => array(
        'cache' => array( 'class' => 'CDummyCache' ),
        'db' => array(
        	'emulatePrepare' => true,
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                        'class'=>'CWebLogRoute',
                        'enabled' => false,
                        'levels' => 'info',
                ),
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'media, error',
					'logFile' => 'errors.log',
				),
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'console',
					'logFile' => 'console.log',
				),
                 array(
                    'class'=>'ext.db_profiler.DbProfileLogRoute',
                    'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.05, // Minimum time for the query to be slow
                ),                       
            ),
        ),

    ),
);
//merge both configurations and return them
return CMap::mergeArray($main, $development);