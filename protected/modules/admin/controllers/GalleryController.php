<?php
/**
 * Gallery controller Home page
 */
class GalleryController extends AdminBaseController {
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_gallery_view');
		
		$this->breadcrumbs[ Yii::t('gallery', 'Gallery') ] = array('gallery/index');
		$this->pageTitle[] = Yii::t('gallery', 'Gallery'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {		
        $this->render('index', array('rows' => Gallery::model()->with(array('coverObject', 'container', 'countImages', 'images', 'images.tiny', 'images.small', 'images.medium', 'images.large'))->byDateDesc()->findAll()));
    }
    
    /**
	 * Add gallery
	 */
	public function actionAddGallery() {
		// Check Access
		checkAccessThrowException('op_gallery_add');
		
		$model = new Gallery;
		
		if( isset( $_POST['Gallery'] ) )
		{
			$model->attributes = $_POST['Gallery'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Added!'));
				$this->redirect(array('gallery/index'));
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding Gallery') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding Gallery');
		
		// Display form
		$this->render('gallery_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Adding Gallery') ));
	}
	
	/**
	 * Edit gallery
	 */
	public function actionEditGallery() {
		// Check Access
		checkAccessThrowException('op_gallery_edit');
		
		if( isset($_GET['id']) && ($model = Gallery::model()->findByPk($_GET['id']) ) )
		{
			if( isset( $_POST['Gallery'] ) )
			{
				$model->attributes = $_POST['Gallery'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
					$this->redirect(array('gallery/index'));
				}
			}
			
			$this->breadcrumbs[ Yii::t('admin', 'Editing Gallery') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing Gallery');

			// Display form
			$this->render('gallery_form', array( 'model' => $model, 'label' => Yii::t('admin', 'Editing Gallery') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Could not find that ID.'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Delete gallery
	 */
	public function actionDeleteGallery() {
		// Check Access
		checkAccessThrowException('op_gallery_delete');
		
		if( isset($_GET['id']) && ( $model = Gallery::model()->findByPk($_GET['id']) ) )
		{			
			// If we have images then we can't delete
			if($model->images) {
				Yii::app()->user->setFlash('error', Yii::t('admin', 'Sorry, There are still active images in that gallery.'));
				$this->redirect(array('gallery/index'));
			}
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Deleted!'));
			$this->redirect(array('gallery/index'));
		}
		else
		{
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Toggle gallery status
	 */
	public function actionToggleStatus() {
		// Check Access
		checkAccessThrowException('op_gallery_toggle_status');
		
		if( isset($_GET['id']) && ( $model = Gallery::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->is_public ? 0 : 1;
			$model->is_public = $update;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('gallery/index'));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Toggle gallery image status
	 */
	public function actionToggleImageStatus($id) {
		// Check Access
		checkAccessThrowException('op_gallery_toggle_status');
		
		if( isset($id) && ( $model = GalleryImage::model()->findByPk( $id ) ) )
		{
			$update = $model->is_public ? 0 : 1;
			$model->is_public = $update;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('gallery/viewgallery', 'id' => $model->gallery_id));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Toggle gallery status
	 */
	public function actionViewGallery($id) {
		// Check Access
		checkAccessThrowException('op_gallery_view_images');
		
		if( isset($id) && ( $model = Gallery::model()->with(array('images', 'images.tiny', 'images.small', 'images.medium', 'images.large'))->findByPk( $id ) ) ) {
			// Did we submit the form and selected items?
			if( isset($_POST) )
			{
				// Check Access
				checkAccessThrowException('op_gallery_manage_images');
				
				// Did we reorder or bulk change status
				if(isset($_POST['reorder'])) {
					// Did we choose any values?
					if( isset($_POST['order']) && count($_POST['order']) )
					{
						foreach($_POST['order'] as $imageId => $imageOrder) {
							GalleryImage::model()->updateByPk($imageId, array('order'=>$imageOrder));	
						}
						// Done
						Yii::app()->user->setFlash('success', Yii::t('admin', '{count} Records Updated.', array('{count}'=>count($_POST['order']))));
						$this->redirect(array('gallery/viewgallery', 'id' => $model->id));
					}
				} else {
					// Did we choose any values?
					if( isset($_POST['record']) && count($_POST['record']) )
					{
						// Did we want to set active or hidden?
						if(isset($_POST['markhidden'])) {
							$status = 0;
						} else {
							$status = 1;
						}
						// Load records and delete them
						$records = GalleryImage::model()->updateByPk(array_keys($_POST['record']), array('is_public'=>$status));
						// Done
						Yii::app()->user->setFlash('success', Yii::t('admin', '{count} Records Updated.', array('{count}'=>$records)));
						$this->redirect(array('gallery/viewgallery', 'id' => $model->id));
					}
				}
			}
			// Render images
			$this->render('view_gallery', array('row' => $model));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Add images to a gallery
	 *
	 *
	 */
	public function actionAddImages($id) {
		// Check Access
		checkAccessThrowException('op_gallery_add_images');
		
		if( isset($id) && ( $model = Gallery::model()->findByPk( $id ) ) ) {
			// Make sure container id is set and exists
			if(!$model->container_id || !MediaContainer::model()->findByPk($model->container_id)) {
				Yii::app()->user->setFlash('error', Yii::t('admin', 'There is no container assigned to that gallery.'));
				$this->redirect(array('gallery/index'));
			}
			$this->render('upload_images', array('row' => $model));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Toggle gallery image cover
	 */
	public function actionMarkCover($id) {
		// Check Access
		checkAccessThrowException('op_gallery_mark_cover');
		
		if( isset($id) && ( $model = GalleryImage::model()->findByPk( $id ) ) )
		{
			// Reset all cover
			Gallery::model()->updateByPk($model->gallery_id, array('cover' => $id));
			
			Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
			$this->redirect(array('gallery/viewgallery', 'id' => $model->gallery_id));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Edit image comment
	 */
	public function actionEditComment($id) {
		// Check Access
		checkAccessThrowException('op_gallery_image_comment');
		
		if( isset($id) && ( $model = GalleryImage::model()->findByPk( $id ) ) )
		{
			if( isset( $_POST['GalleryImage'] ) )
			{
				$model->attributes = $_POST['GalleryImage'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('admin', 'Record Updated!'));
					$this->redirect(array('gallery/viewgallery', 'id' => $model->gallery_id));
				}
			}
			
			$this->breadcrumbs[ Yii::t('admin', 'Editing Comment') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing Comment');

			// Display form
			$this->render('image_comment', array( 'model' => $model, 'label' => Yii::t('admin', 'Editing Comment') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('admin', 'Record was not found!'));
			$this->redirect(array('gallery/index'));
		}
	}
	
	/**
	 * Returns a thumbnail of an image - inline
	 *
	 */
	public function actionImageThumb() {
		header("Content-type: application/image");
		$image = new ImageThumb( getUploadsPath() . '/thumb_cache/' );
		$image->run();
		Yii::app()->end();
	}
	
	/**
	 * Upload images coming from jumploader
	 *
	 */
	public function actionUploadImages($gallery_id) {
		// Make sure that gallery exists
		$gallery = Gallery::model()->with(array('club'))->findByPk( $gallery_id );
		if(!$gallery || !$gallery->container_id) {
			Yii::log('error', 'Gallery id ' . $gallery_id . ' was not found');
			throw new CHttpException(400, Yii::t('admin', 'Gallery does not exists.'));
		}
		
		$images = array();
		$galleryImage = new GalleryImage;
		$tempoFile = null;
		
		// Loop through files and upload them
		foreach($_FILES as $name => $file) {
			// Load the media object
			$object = new MediaObject;
			$object->file = CUploadedFile::getInstanceByName($name);
			$object->container_id = $gallery->container_id;
			$object->realName = $name . '_' . $_POST['fileName'];
			$object->is_active = 1;
			
			// Only apply to large
			if($name == 'large') {
				// We have to upload it temporarly then we will delete it
				$tempoFile = getUploadsPath() . '/' .sha1(microtime(true)) . '.' . $object->getExt($object->file->getName());
				$object->file->saveAs($tempoFile, false);
				
				//file_put_contents(Yii::getPathOfAlias('application.runtime') . '/errors.log', sprintf("Preparing to waterkmark %s, %s", $name, $tempoFile), FILE_APPEND);
				// Log
				Yii::log('error', sprintf("Preparing to waterkmark %s, %s", $name, $tempoFile));
				
				// First lets add watermarks
				$imageWatermark = new ImageWatermark;
			  	$imageWatermark->init( array(
			  					'image_file' => $tempoFile,
			  					'margin' => 5,
			  					)		);
			  	if(!$imageWatermark->error) {
			  		// Do we want to add a watermark
			  		if($gallery->watermark_logo) {
			  			// Add our watermark
			  			$imageWatermark->addWatermark( getUploadsPath() . '/watermark.png');
			  		}
			  		
			  		// If we have a club assigned and that club has it's own watermark we will add that too
			  		// on the bottom left corner of the image
			  		if($gallery->watermark_club_logo && $gallery->club_id && $gallery->club && $gallery->club->watermark) {
			  			// Add club watermark
			  			$imageWatermark->addWatermark( $gallery->club->watermark, 'bottom-left' );
			  		}
			  		
			  		if($imageWatermark->writeImage()) {
			  			// Make sure we switch the tmp file with the new file
			  			$fileWritten = file_put_contents($object->file->getTempName(), file_get_contents($tempoFile));
			  			if(!$fileWritten) {
			  				//file_put_contents(Yii::getPathOfAlias('application.runtime') . '/errors.log', 'Could not write to tp file', FILE_APPEND);
			  				Yii::log('error', 'Could not write to temp file');
			  			}
			  		} else {
			  			// ERROR
			  			//file_put_contents(Yii::getPathOfAlias('application.runtime') . '/errors.log', 'Could not watermark ' . $imageWatermark->error, FILE_APPEND);
			  			Yii::log('error', 'Could not watermark ' . $imageWatermark->error);
			  		}
			  	} else {
			  		//file_put_contents(Yii::getPathOfAlias('application.runtime') . '/errors.log', 'Could not watermark ' . $imageWatermark->error, FILE_APPEND);
			  		Yii::log('error', 'Could not watermark ' . $imageWatermark->error);
			  	}
			}			 
			
			if($object->save()) {
				$images[$name] = $object;
			} else {
				Yii::log('error', 'File was not uploaded ' . $name . '.');
				throw new CHttpException(400, Yii::t('admin', 'Could not upload Image.'));
			}	
		}
		
		// Add in the 
		if(count($images)) {
			// Add in the gallery image row
			$galleryImage->gallery_id = $gallery_id;
			$galleryImage->is_public = 1;
			foreach($images as $imageName => $image) {
				// Add relations between the object and gallery
				$columnName = $imageName . '_object_id';
				$galleryImage->$columnName = $image->id;
			}
			if(!$galleryImage->save()) {
				Yii::log('error', 'Could not save gallery image.');
			}
		}
		
		// Delete large tempo file
		if($tempoFile && file_exists($tempoFile)) {
			@unlink($tempoFile);
		}
		
		Yii::app()->end();
	}
}