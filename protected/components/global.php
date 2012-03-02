<?php

/**
 * Shortcuts to various methods, variables and classes
 *
 *
 */
 
// Set default time zone
date_default_timezone_set('America/Los_Angeles'); 
 
/**
 * Returns the current active theme base url
 *
 */ 
function themeUrl() {
	return Yii::app()->themeManager->baseUrl;
}

/**
 * Create url
 * @param string
 * @return string
 */
function createUrl($url) {
	return Yii::app()->urlManager->createUrl($url);
}

/**
 * Check if there is a user flash set
 * @param string $key
 * @return boolean
 */
function hasFlash($key) {
	return Yii::app()->user->hasFlash($key);
}

/**
 * Get the user flash set
 * @param string $key
 * @return string
 */
function getFlash($key) {
	return Yii::app()->user->getFlash($key);
}

/**
 * Set user flash
 * @param string $key
 * @param string $value
 * @return string
 */
function setFlash($key, $value) {
	return Yii::app()->user->setFlash($key, $value);
}

/**
 * Return the CWebUser object
 * @return object
 */
function getUser() {
	return Yii::app()->user;
}

/**
 * Return app param
 * @return mixed
 */
function getParam($key, $default=null) {
	return Yii::app()->settings->get($key, $default);
}

/**
 * Return request param
 * @param string $key
 * @param string $default
 * @return mixed
 */
function getRParam($key, $default=null) {
	return Yii::app()->request->getParam($key, $default);
}

/**
 * Register script file
 * @param string $url
 * @param string $position
 * @return void
 */
function JSFile($url,$position=CClientScript::POS_END) {
	Yii::app()->clientScript->registerScriptFile($url, $position);
}

/**
 * Register script code
 * @param string $id
 * @param string $script
 * @param string $position
 * @return void
 */
function JSCode($id, $script, $position=CClientScript::POS_END) {
	Yii::app()->clientScript->registerScript($id, $script, $position);
}

/**
 * Regsiter css file
 * @param string $url
 * @param string $media
 * @return void
 */
function CSSFile($url,$media='') {
	Yii::app()->clientScript->registerCssFile($url, $media);
}

/**
 * Publish file
 * @param string $url
 * @return string
 */
function publish($location) {
	return Yii::app()->assetManager->publish($location);
}

/**
 * Check if user has access to $key
 * @param string $key
 * @return boolean
 */
function checkAccess($key) {
	return Yii::app()->user->checkAccess($key);
}

/**
 * Get application base path
 * @return string
 */
function getBasePath() {
	return Yii::getPathOfAlias('webroot');
}

/**
 * Get application base url
 * @return string
 */
function getBaseUrl() {
	return Yii::app()->baseUrl;
}

/**
 * Get uploads base path
 * @return string
 */
function getUploadsPath() {
	$path = getBasePath();
	if(getParam('uploads_dir')) {
		$path .= '/'.getParam('uploads_dir');
	}
	return $path;
}

/**
 * Get uploads base url
 * @return string
 */
function getUploadsUrl() {
	$url = getBaseUrl();
	if(getParam('uploads_dir')) {
		$url .= '/'.getParam('uploads_dir');
	}
	return $url;
}

/**
 * Return a formatted date and time
 * @param int $timestamp
 * @param string $dateWidth
 * @param string $timeWidth
 * @return string
 */
function dateTime($timestamp, $dateWidth='short', $timeWidth='short') {
	return Yii::app()->dateFormatter->formatDateTime($timestamp, $dateWidth, $timeWidth);
}

/**
 * Return a formatted date only
 * @param int $timestamp
 * @param string $dateWidth
 * @param string $timeWidth
 * @return string
 */
function dateOnly($timestamp, $dateWidth='short', $timeWidth=null) {
	return Yii::app()->dateFormatter->formatDateTime($timestamp, $dateWidth, $timeWidth);
}

/**
 * Return a formatted number
 * @param int $int
 * @return string
 */
function numberFormat($int) {
	return Yii::app()->format->number($int);
}

/**
 * Return a formatted bytes size
 * @param int $bytes
 * @return string
 */
function formatBytes($bytes) {
   if ($bytes < 1024) return intval($bytes).' B';
   elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
   elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
   elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
   else return round($bytes / 1099511627776, 2).' TB';
}

/**
 * Check if user has access to $key
 * if not throw an exception
 * @param string $key
 * @return exception
 */
function checkAccessThrowException($key) {
	if(!checkAccess($key)) {
		throw new CHttpException(403, Yii::t('error', 'Sorry, You don\'t have the required permissions to enter or perform this action.'));
	}
}