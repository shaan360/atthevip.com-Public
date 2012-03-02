<?php
/**
 * Login controller
 */
class LoginController extends AdminBaseController {
	public $layout = 'login';
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		$this->breadcrumbs[ Yii::t('login', 'Login') ] = array('login/index');
		$this->pageTitle[] = Yii::t('login', 'Login'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {	
    	$form = new AdminLogin;
    	if(isset($_POST['AdminLogin'])) {
    		$form->setAttributes($_POST['AdminLogin']);
    		if($form->validate()) {
    			// Login
    			Yii::app()->user->login($form->identity);
    			
    			AdminUsers::model()->deleteAll('userid=:id', array(':id' => Yii::app()->user->id));
    			
    			// Update admin login table
    			$admin = new AdminUsers;
    			$admin->save();
    			
    			// Add to session the last time we clicked
    			Yii::app()->session['admin_clicked'] = time();
    			
    			setFlash('sucess', Yii::t('admin', 'You are not logged in.'));
    			$this->redirect(array('index/index'));
    		} else {
    			// Add errors
    			setFlash('error', implode('<br />', $form->getErrors('password')));
    		}
    	}  		
        $this->render('index', array('form' => $form));
    }
}