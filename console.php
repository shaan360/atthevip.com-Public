<?php
exit;
// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';

// Define root directory
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__) . '/');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

if( YII_DEBUG === true ) {
    ini_set('display_errors', true);
    error_reporting(E_ALL);
} else {
    //ini_set('display_errors', false);
    //error_reporting(0);
    ini_set('display_errors', true);
    error_reporting(E_ALL);
}

require_once($yii);
require_once('protected/components/global.php');
Yii::createConsoleApplication($config)->run();