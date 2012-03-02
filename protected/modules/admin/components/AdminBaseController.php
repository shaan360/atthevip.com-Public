<?php
/**
 * Admin base controller class
 */
class AdminBaseController extends BaseController {
	
	/**
	 * admins breadcrumbs
	 */
	public $breadcrumbs = array();
	
	/**
	 * Add subpages to the bottom of the current active controller
	 * title=>url
	 */
	public $subPages = array();
	
    /**
     * Class constructor
     *
     */
    public function init() {		
	
		// Add default page title which is the application name
        $this->pageTitle[] = Yii::t('global', Yii::app()->name);
		$this->pageTitle[] = Yii::t('global', 'Admin');
		
		// By default we register the robots to 'none'
        Yii::app()->clientScript->registerMetaTag( 'noindex, nofollow', 'robots' );

		// We add a meta 'language' tag based on the currently viewed language
		Yii::app()->clientScript->registerMetaTag( Yii::app()->language, 'language', 'content-language' );
		
		// Make sure we have access
		if( !Yii::app()->user->id || !checkAccess('op_acp_access') )
		{
			// Do we need to login
			if(!Yii::app()->user->id && Yii::app()->getController()->id != 'login') {
				$this->redirect(array('login/index'));
			}
			
			// Make sure we are not in login page
			if(Yii::app()->getController()->id != 'login') {
				throw new CException(Yii::t('error', 'Sorry, You are not allowed to enter this section.') );
			}
		}
		
		// Check if we haven't clicked more then X amount of time
		$maxIdleTime = 60 * 60 * 5; // 5 hour
		if(Yii::app()->getController()->id != 'login' && time() - $maxIdleTime > Yii::app()->session['admin_clicked'] ) {
			// Loguser out and redirect to login
			AdminUsers::model()->deleteAll('userid=:id', array(':id' => Yii::app()->user->id));
			Yii::app()->user->logout();
			setFlash('error', Yii::t('admin', 'Your session expired. Please login.'));
			$this->redirect(array('login/index'));
		}
		
		// Update record info
		Yii::app()->session['admin_clicked'] = time();
		AdminUsers::model()->updateAll(array('lastclick_time' => time(), 'location' => Yii::app()->getController()->id), 'userid=:id', array(':id' => Yii::app()->user->id));
		
		/* Run init */
        parent::init();
    }
}