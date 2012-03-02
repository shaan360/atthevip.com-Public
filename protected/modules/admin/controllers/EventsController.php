<?php
/**
 * Events controller Home page
 */
class EventsController extends AdminBaseController {
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_events_view');
		
		$this->breadcrumbs[ Yii::t('events', 'Events') ] = array('events/index');
		$this->pageTitle[] = Yii::t('events', 'Events'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {		
    	// Did we submit the form and selected items?
		if( checkAccess('op_events_manage') && isset($_POST['bulkoperations']) && $_POST['bulkoperations'] != '' )
		{
			// Did we choose any values?
			if( isset($_POST['record']) && count($_POST['record']) )
			{
				// What operation we would like to do?
				switch( $_POST['bulkoperations'] )
				{
					case 'bulkdelete':
					
					// Check Access
					checkAccessThrowException('op_events_bulkdelete');
					
					// Load comments and delete them
					$deleted = Event::model()->deleteByPk(array_keys($_POST['record']));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('news', '{count} events deleted.', array('{count}'=>$deleted)));
					break;
					
					case 'bulkapprove':
					// Load comments
					$records = Event::model()->updateByPk(array_keys($_POST['record']), array('is_public'=>1));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('news', '{count} events approved.', array('{count}'=>$records)));
					break;
					
					case 'bulkunapprove':
					// Load comments
					$records = Event::model()->updateByPk(array_keys($_POST['record']), array('is_public'=>0));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('news', '{count} events Un-Approved.', array('{count}'=>$records)));
					break;
					
					default:
					// Nothing
					break;
				}
			}
		}
		
        $this->render('index', array('rows' => Event::model()->byCreatedDate()->with(array('club', 'countGalleries'))->findAll()));
    }
    
    /**
	 * Add event
	 */
	public function actionAddEvent() {
		// Check Access
		checkAccessThrowException('op_events_add');
		
		$model = new Event;
		
		if( isset( $_POST['Event'] ) )
		{
			$model->attributes = $_POST['Event'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Added!'));
				$this->redirect(array('events/index'));
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding Event') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding Event');
		
		// Display form
		$this->render('event_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Adding Event') ));
	}
	
	/**
	 * Edit event
	 */
	public function actionEditEvent($id) {
		// Check Access
		checkAccessThrowException('op_events_edit');
		
		if( isset($id) && ($model = Event::model()->findByPk($id) ) )
		{
			if( isset( $_POST['Event'] ) )
			{
				$model->attributes = $_POST['Event'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
					$this->redirect(array('events/index'));
				}
			}
			
			$this->breadcrumbs[ Yii::t('admin', 'Editing Event') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing Event');

			// Display form
			$this->render('event_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Editing Event') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Could not find that ID.'));
			$this->redirect(array('events/index'));
		}
	}
	
	/**
	 * Delete event
	 */
	public function actionDeleteEvent() {
		// Check Access
		checkAccessThrowException('op_events_delete');
		
		if( isset($_GET['id']) && ( $model = Event::model()->findByPk($_GET['id']) ) )
		{			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Deleted!'));
			$this->redirect(array('events/index'));
		}
		else
		{
			$this->redirect(array('events/index'));
		}
	}
	
	/**
	 * Toggle event status
	 */
	public function actionToggleStatus() {
		// Check Access
		checkAccessThrowException('op_events_toggle_status');
		
		if( isset($_GET['id']) && ( $model = Event::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->is_public ? 0 : 1;
			$model->is_public = $update;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('events/index'));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('events/index'));
		}
	}
}