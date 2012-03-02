<?php
/**
 * Events controller Home page
 */
class EventsController extends SiteBaseController {
	/**
	 * Controller constructor
	 */
    public function init() {
        parent::init();
    }
    
    /**
	 * show all events by date added
	 *
	 */
	public function actionIndex() {
		// Load items and display
		$criteria = new CDbCriteria;

		$count = Event::model()->isPublic()->byDateAsc()->count();
		$pages = new CPagination($count);
		$pages->pageSize = getParam('events_per_page', 25);
		$pages->applyLimit($criteria);
		
		$events = Event::model()->with(array('club'))->isPublic()->byCreatedDate()->findAll($criteria);
		
		$this->pageTitle[] = Yii::t('events', 'All Events');
		$this->render('events_list', array('events' => $events, 'pages' => $pages, 'title' => Yii::t('events', 'Events')));
	}
	
	/**
	 * show upcoming events
	 *
	 */
	public function actionUpcoming() {
		// Load items and display
		$criteria = new CDbCriteria;

		$count = Event::model()->upcoming()->isPublic()->byDateAsc()->count();
		$pages = new CPagination($count);
		$pages->pageSize = getParam('events_per_page', 25);
		$pages->applyLimit($criteria);
		
		$events = Event::model()->with(array('club'))->upcoming()->isPublic()->byDateAsc()->findAll($criteria);
		
		$this->pageTitle[] = Yii::t('events', 'Upcoming Events');
		$this->render('events_list', array('events' => $events, 'pages' => $pages, 'title' => Yii::t('events', 'Upcoming Events')));
	}
	
	/**
	 * View a single event
	 *
	 *
	 */
	public function actionViewEvent($id, $alias) {
		if($id && $alias && ( $event = Event::model()->isPublic()->find('id=:id AND alias=:alias', array(':id' => $id, ':alias' => $alias)) )) {
			
			$this->pageTitle[] = Yii::t('events', $event->title);
			$this->render('view_event', array('event' => $event));
		} else {
			throw new CHttpException(404, Yii::t('events', 'Sorry, That event was not found.'));
		}
	}
}