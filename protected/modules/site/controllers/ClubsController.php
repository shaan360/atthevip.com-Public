<?php
/**
 * Clubs controller Home page
 */
class ClubsController extends SiteBaseController {
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

		$count = Club::model()->isPublic()->byName()->count();
		$pages = new CPagination($count);
		$pages->pageSize = getParam('events_per_page', 25);
		$pages->applyLimit($criteria);
		
		$clubs = Club::model()->with(array('eventsCount', 'events'))->isPublic()->byName()->findAll($criteria);
		
		$this->pageTitle[] = Yii::t('clubs', 'All Clubs');
		$this->render('clubs_list', array('clubs' => $clubs, 'pages' => $pages, 'title' => Yii::t('clubs', 'Clubs')));
	}
	
	/**
	 * View a single club
	 *
	 *
	 */
	public function actionViewClub($id, $alias) {
		if($id && $alias && ( $club = Club::model()->isPublic()->find('id=:id AND alias=:alias', array(':id' => $id, ':alias' => $alias)) )) {
			
			$this->pageTitle[] = Yii::t('clubs', $club->name);
			$this->render('view_club', array('club' => $club));
		} else {
			throw new CHttpException(404, Yii::t('events', 'Sorry, That club was not found.'));
		}
	}
}