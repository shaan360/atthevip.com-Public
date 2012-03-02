<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yiilite.php';
$config=dirname(__FILE__).'/protected/config/';
require_once('protected/config/config.php');
// Define root directory
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__) . '/');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', DEBUG_MODE);

if( YII_DEBUG === true ) {
    ini_set('display_errors', true);
    error_reporting(E_ALL);
} else {
    //ini_set('display_errors', false);
    //error_reporting(0);
    ini_set('display_errors', true);
    error_reporting(E_ALL);
}

$configFile = YII_DEBUG ? 'dev.php' : 'production.php';

require_once($yii);
require_once('protected/components/global.php');
Yii::createWebApplication($config . $configFile)->run();