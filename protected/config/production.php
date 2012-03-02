<?php

// Load main config file
$main = require_once( 'main.php' );

// Production configurations
$production = array(
	'components' => array(		
		'log' => array(
	        'class' => 'CLogRouter',
			'routes' => array(
				// Configures Yii to email all errors and warnings to an email address
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
			),
        ),
    ),
);
//merge both configurations and return them
return CMap::mergeArray($main, $production);