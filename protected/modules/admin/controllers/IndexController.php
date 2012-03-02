<?php
/**
 * Index controller Home page
 */
class IndexController extends AdminBaseController {
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_index_view');
		
		$this->breadcrumbs[ Yii::t('index', 'Dashboard') ] = array('index/index');
		$this->pageTitle[] = Yii::t('index', 'Dashboard'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {	  		
        $this->render('index');
    }
}