<?php
/**
 * Gallery controller Home page
 */
class GalleryController extends SiteBaseController {
	/**
	 * Controller constructor
	 */
    public function init() {
        parent::init();
    }
    
    /**
	 * Returns a thumbnail of an image - inline
	 *
	 */
	public function actionImageThumb() {
		header("Content-type: application/image");
		$image = new ImageThumb( getUploadsPath() . '/event_thumb_cache/' );
		$image->run();
		Yii::app()->end();
	}
	
	/**
	 * Show all galleries by date added
	 */
	public function actionIndex() {
		// Load items and display
		$criteria = new CDbCriteria;

		$count = Gallery::model()->isPublic()->byDateDesc()->count();
		$pages = new CPagination($count);
		$pages->pageSize = getParam('events_per_page', 25);
		$pages->applyLimit($criteria);
		
		$rows = Gallery::model()->with(array('club', 'event', 'countVisibleImages', 'coverObject'))->isPublic()->byCreatedDate()->findAll($criteria);
		
		$this->pageTitle[] = Yii::t('gallery', 'All Events');
		$this->render('gallery_list', array('rows' => $rows, 'pages' => $pages, 'title' => Yii::t('gallery', 'Galleries')));
	}
	
	/**
	 * View a single gallery
	 *
	 *
	 */
	public function actionViewGallery($id, $alias) {
		if($id && $alias && ( $row = Gallery::model()->with(array('club', 'event', 'visibleImages', 'countVisibleImages', 'visibleImages.large', 'visibleImages.medium', 'visibleImages.small'))->isPublic()->find('t.id=:id AND t.alias=:alias', array(':id' => $id, ':alias' => $alias)) )) {
			
			// Update the views
			$row->views++;
			$row->update();
			
			$this->pageTitle[] = Yii::t('gallery', $row->name);
			$this->render('view_gallery', array('row' => $row));
		} else {
			throw new CHttpException(404, Yii::t('events', 'Sorry, That gallery was not found.'));
		}
	}
}