<?php
/**
 * Clubs controller Home page
 */
class ClubsController extends AdminBaseController {
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_clubs_view');
		
		$this->breadcrumbs[ Yii::t('clubs', 'Clubs') ] = array('clubs/index');
		$this->pageTitle[] = Yii::t('clubs', 'Clubs'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {		
        $this->render('index', array('rows' => Club::model()->with(array('eventsCount'))->findAll()));
    }
    
    /**
	 * Add club
	 */
	public function actionAddClub() {
		// Check Access
		checkAccessThrowException('op_clubs_add');
		
		$model = new Club;
		
		if( isset( $_POST['Club'] ) )
		{
			$model->attributes = $_POST['Club'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Added!'));
				$this->redirect(array('clubs/index'));
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding club') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding club');
		
		// Display form
		$this->render('club_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Adding club') ));
	}
	
	/**
	 * Edit club
	 */
	public function actionEditClub() {
		// Check Access
		checkAccessThrowException('op_clubs_edit');
		
		if( isset($_GET['id']) && ($model = Club::model()->findByPk($_GET['id']) ) )
		{
			if( isset( $_POST['Club'] ) )
			{
				$model->attributes = $_POST['Club'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
					$this->redirect(array('clubs/index'));
				}
			}
			
			$this->breadcrumbs[ Yii::t('admin', 'Editing club') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing club');

			// Display form
			$this->render('club_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Editing club') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Could not find that ID.'));
			$this->redirect(array('clubs/index'));
		}
	}
	
	/**
	 * Delete club
	 */
	public function actionDeleteClub() {
		// Check Access
		checkAccessThrowException('op_clubs_delete');
		
		if( isset($_GET['id']) && ( $model = Club::model()->findByPk($_GET['id']) ) )
		{			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Deleted!'));
			$this->redirect(array('clubs/index'));
		}
		else
		{
			$this->redirect(array('clubs/index'));
		}
	}
	
	/**
	 * Toggle clubs status
	 */
	public function actionToggleStatus() {
		// Check Access
		checkAccessThrowException('op_clubs_toggle_status');
		
		if( isset($_GET['id']) && ( $model = Club::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->is_public ? 0 : 1;
			$model->is_public = $update;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('clubs/index'));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('clubs/index'));
		}
	}
}