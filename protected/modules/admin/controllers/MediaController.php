<?php
/**
 * Media controller Home page
 */
class MediaController extends AdminBaseController {
	/**
	 * @var object rackspace files wrapper class
	 */
	public $rackspace;
	
	/**
	 * init
	 */
	public function init()
	{
		// Check Access
		checkAccessThrowException('op_media_view');
		
		// Make sure uploads directory is set
		if(!getParam('uploads_dir')) {
			throw new CHttpException(500, Yii::t('media', 'Sorry, You must set the uploads directory first.'));
		}
		
		// Make sure it works
		if(getParam('rackspace_username') && getParam('rackspace_api_key')) {
			// Load the classes
			Yii::import('ext.RackspaceFiles');
			$this->rackspace = new RackspaceFiles(getParam('rackspace_username'), getParam('rackspace_api_key'));
			try {
				$this->rackspace->connect();
			} catch (Exception $e) {
				$this->rackspace = null; // reset
			}
		}
		
		parent::init();
		
		$this->breadcrumbs[ Yii::t('media', 'Media') ] = array('media/index');
		$this->pageTitle[] = Yii::t('media', 'Media'); 
	}
	
	/**
	 * Custom actions for this controller
	 *
	 */
	public function actions() {
	   return array(
	      'elfinder.' => 'application.widgets.elfinder.FinderWidget',
	    );
	}
	
	/**
	 * Index action
	 * Index will show the el finder widget
	 */
    public function actionIndex() {		
        $this->render('index');
    }
    
    /**
     * Get containers
     *
     */
    public function actionRackSpace() {
    	// Make sure the rackspace object is ready
    	if(!$this->rackspace) {
    		throw new CHttpException(500, Yii::t('media', 'Sorry, The rackspace settings are not set properly or we could not connect.'));
    	}
    	
    	// Did we submit the form and selected items?
		if( isset($_POST['bulkoperations']) && $_POST['bulkoperations'] != '' )
		{
			// Check Access
			checkAccessThrowException('op_media_manage_containers');
			
			// Did we choose any values?
			if( isset($_POST['record']) && count($_POST['record']) )
			{
				// What operation we would like to do?
				switch( $_POST['bulkoperations'] )
				{	
					case 'bulkapprove':
					// Load records
					$records = MediaContainer::model()->findAllByPk(array_keys($_POST['record']));
					foreach($records as $record) {
						$record->is_public = 1;
						$record->update();
					}
					// Done
					Yii::app()->user->setFlash('success', Yii::t('admin', '{count} containers published.', array('{count}'=>count($records))));
					break;
					
					case 'bulkunapprove':
					// Load records
					$records = MediaContainer::model()->findAllByPk(array_keys($_POST['record']));
					foreach($records as $record) {
						$record->is_public = 0;
						$record->update();
					}
					// Done
					Yii::app()->user->setFlash('success', Yii::t('admin', '{count} containers Un-Published.', array('{count}'=>count($records))));
					break;
					
					default:
					// Nothing
					break;
				}
			}
		}
		
		$rows = MediaContainer::model()->with(array('objectCount'))->byDate()->findAll();
    	
    	// List containers
    	$this->render('containers', array('rows' => $rows));
    }
    
    /**
	 * Add media container
	 */
	public function actionAddContainer() {
		// Check Access
		checkAccessThrowException('op_media_add_container');
		
		$model = new MediaContainer;
		
		if( isset( $_POST['MediaContainer'] ) )
		{
			$model->attributes = $_POST['MediaContainer'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Added!'));
				$this->redirect(array('media/rackspace'));
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding media container') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding media container');
		
		// Display form
		$this->render('container_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Adding media container') ));
	}
	
	/**
	 * Edit media container
	 */
	public function actionEditContainer() {
		// Check Access
		checkAccessThrowException('op_media_edit_container');
		
		if( isset($_GET['id']) && ($model = MediaContainer::model()->findByPk($_GET['id']) ) )
		{
			if( isset( $_POST['MediaContainer'] ) )
			{
				$model->attributes = $_POST['MediaContainer'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
					$this->redirect(array('media/rackspace'));
				}
			}
			
			$this->breadcrumbs[ Yii::t('admin', 'Editing media container') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing media container');

			// Display form
			$this->render('container_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Editing media container') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Could not find that ID.'));
			$this->redirect(array('rackspace/index'));
		}
	}
	
	/**
	 * Delete media container
	 */
	public function actionDeleteContainer() {
		// Check Access
		checkAccessThrowException('op_media_delete_container');
		
		if( isset($_GET['id']) && ( $model = MediaContainer::model()->with(array('objects'))->findByPk($_GET['id']) ) )
		{
			// Do we have any settings in it?
			if( count($model->objects) )
			{
				Yii::app()->user->setFlash('error', Yii::t('admin', "Can't delete that container as it contains active objects."));
				$this->redirect(array('media/rackspace'));
			}
			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Deleted!'));
			$this->redirect(array('media/rackspace'));
		}
		else
		{
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * Toggle container status
	 */
	public function actionToggleContainerStatus() {
		// Check Access
		checkAccessThrowException('op_media_container_status');
		
		if( isset($_GET['id']) && ( $model = MediaContainer::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->is_public ? 0 : 1;
			$model->is_public = $update;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('media/rackspace'));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * View media container
	 */
	public function actionViewContainer()
	{
		// Check Access
		checkAccessThrowException('op_media_view_container');
		
		if( isset($_GET['id']) && ( $container = MediaContainer::model()->findByPk($_GET['id']) ) )
		{
			
	    	// Did we submit the form and selected items?
			if( isset($_POST['bulkoperations']) && $_POST['bulkoperations'] != '' )
			{
				// Check Access
				checkAccessThrowException('op_media_manage_objects');
				
					// Did we choose any values?
					if( isset($_POST['record']) && count($_POST['record']) )
					{
						// What operation we would like to do?
						switch( $_POST['bulkoperations'] )
						{	
							case 'bulkdelete':
							// Check access
							checkAccessThrowException('op_media_bulk_objects_delete');	
								
							// Load records
							$records = MediaObject::model()->findAllByPk(array_keys($_POST['record']));
							foreach($records as $record) {
								$record->delete();
							}
							// Done
							Yii::app()->user->setFlash('success', Yii::t('admin', '{count} objects deleted.', array('{count}'=>count($records))));
							break;
							
							case 'bulkapprove':
							// Load records
							$records = MediaObject::model()->findAllByPk(array_keys($_POST['record']));
							foreach($records as $record) {
								$record->is_active = 1;
								$record->update();
							}
							// Done
							Yii::app()->user->setFlash('success', Yii::t('admin', '{count} objects published.', array('{count}'=>count($records))));
							break;
							
							case 'bulkunapprove':
							// Load records
							$records = MediaObject::model()->findAllByPk(array_keys($_POST['record']));
							foreach($records as $record) {
								$record->is_active = 0;
								$record->update();
							}
							// Done
							Yii::app()->user->setFlash('success', Yii::t('admin', '{count} objects Un-Published.', array('{count}'=>count($records))));
							break;
							
							default:
							// Nothing
							break;
						}
					}
				}
			
			// Set title and breadcrumbs
			$this->breadcrumbs[ Yii::t('admin', 'Viewing Container') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Viewing Container' );
			
			// Render
			$this->render('objects_view', array( 'container' => $container ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Could not find that ID.'));
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * Add media object
	 */
	public function actionAddObject() {
		// Check Access
		checkAccessThrowException('op_media_add_object');
		
		$model = new MediaObject;
		
		if( isset( $_POST['MediaObject'] ) ) {
			$model->attributes = $_POST['MediaObject'];
			$model->file = CUploadedFile::getInstance($model, 'file');
			if( $model->save() ) {
				Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Added!'));
				$model->container->updateContainerInfo($model->container_id);
				$this->redirect(array('media/viewcontainer', 'id' => $model->container_id));
			}
		} else {
			if(getRParam('container_id')) {
				$model->container_id = getRParam('container_id');
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding media object') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding media object');
		
		// Display form
		$this->render('object_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Adding media object') ));
	}
	
	/**
	 * Edit media object
	 */
	public function actionEditObject()
	{
		// Check Access
		checkAccessThrowException('op_media_edit_object');
		
		if( isset($_GET['id']) && ( $model = MediaObject::model()->findByPk($_GET['id']) ) )
		{
			if( ( $container = MediaContainer::model()->findByPk($model->container_id) ) )
			{
				$model->container_id = $container->id;
			
				$this->breadcrumbs[ Yii::t('admin', 'Editing media object') ] = array('media/rackspace', 'id' => $container->id);
				$this->pageTitle[] = Yii::t('admin', 'Editing media object');
			}
		
			if( isset( $_POST['MediaObject'] ) )
			{
				$model->attributes = $_POST['MediaObject'];
				$model->file = CUploadedFile::getInstance($model, 'file');
				if( $model->save() )
				{
					
					Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
					$this->redirect(array('media/viewcontainer', 'id' => $model->container_id));
				}
			}
		
			$this->breadcrumbs[ Yii::t('admin', 'Editing media object') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing media object');
		
			// Display form
			$this->render('object_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Editing media object') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Could not find that ID.'));
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * Delete media object
	 */
	public function actionDeleteObject() {
		// Check Access
		checkAccessThrowException('op_media_delete_object');
		
		if( isset($_GET['id']) )
		{
			$model = MediaObject::model()->findByPk($_GET['id']);
			
			MediaObject::model()->deleteByPk($_GET['id']);
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record deleted.'));
			if($model) {
				$this->redirect(array('media/viewcontainer', 'id' => $model->container_id));
			}
			$this->redirect(array('media/rackspace'));
		}
		else
		{
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * Toggle object status
	 */
	public function actionToggleObjectStatus() {
		// Check Access
		checkAccessThrowException('op_media_object_status');
		
		if( isset($_GET['id']) && ( $model = MediaObject::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->is_active ? 0 : 1;
			$model->is_active = $update;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('media/viewcontainer', 'id' => $model->container_id));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * Toggle object status
	 */
	public function actionSyncContainer() {
		// Check Access
		checkAccessThrowException('op_media_sync_containers');
		
		if( isset($_GET['id']) && ( $model = MediaContainer::model()->findByPk( $_GET['id'] ) ) )
		{
			$model->updateContainerInfo($model->name);
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Synced!'));
			$this->redirect(array('media/rackspace'));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('media/rackspace'));
		}
	}
	
	/**
	 * Show jumploader uploader
	 *
	 */
	public function actionJumpLoader($container_id) {
		$this->render('jump_loader');
	}
	
	/**
	 * Upload images coming from jumploader
	 *
	 */
	public function actionUploadObjects($container_id) {
		foreach($_FILES as $name => $file) {
			// Load the media object
			$object = new MediaObject;
			$object->file = CUploadedFile::getInstanceByName($name);
			$object->container_id = $container_id;
			$object->realName = $name . '_' . $_POST['fileName'];
			$object->is_active = 1;
			if($object->save()) {
				continue;
			} else {
				break;
			}	
		}
	}
	
	/**
	 * Sync containers
	 *
	 */
	public function actionSyncContainers() {
		// Check Access
		checkAccessThrowException('op_media_sync_containers');
		$rows = MediaContainer::model()->findAll();
		foreach($rows as $row) {
			$row->updateContainerInfo($row->name);
		}
		
		Yii::app()->user->setFlash('success', Yii::t('admin', 'Containers Synced!'));
		$this->redirect(array('media/rackspace'));
	}
}