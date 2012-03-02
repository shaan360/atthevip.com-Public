<?php
/**
 * Admin module class
 */
class AdminModule extends MasterModule {
    
	/**
	 * Default admin theme
	 */
	public $theme = 'admin';

	/**
     * Module constructor - Builds the initial module data
     *
     * @author vadim
     */
    public function init() {
	
		Yii::app()->theme = $this->theme;
		
		
		// Set theme url
        Yii::app()->themeManager->setBaseUrl( Yii::app()->theme->baseUrl );
        // Load files from rackspace
        if(getParam('adminThemeUrl')) {
        	Yii::app()->themeManager->setBaseUrl( getParam('adminThemeUrl') );
        }
        Yii::app()->themeManager->setBasePath( Yii::app()->theme->basePath );
	
		// Set error handler
		Yii::app()->errorHandler->errorAction = 'admin/error/error';
	
        /* Make sure we run the master module init function */
        parent::init();
    }
}