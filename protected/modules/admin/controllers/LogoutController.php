<?php
/**
 * Logout controller
 */
class LogoutController extends AdminBaseController {
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Make sure we are logged in
		if(!Yii::app()->user->id) {
			$this->redirect(array('login/index'));
		}
		
		$this->breadcrumbs[ Yii::t('login', 'Login') ] = array('login/index');
		$this->pageTitle[] = Yii::t('login', 'Login'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {	
    	// Delete records for this users from admin logged in
    	AdminUsers::model()->deleteAll('userid=:id', array(':id' => Yii::app()->user->id));
    	Yii::app()->user->logout();
    	setFlash('sucess', Yii::t('admin', 'You are not logged out.'));
    	$this->redirect(array('login/index'));
    }
}