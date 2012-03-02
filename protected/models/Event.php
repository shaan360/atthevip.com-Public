<?php
/**
 * Event model
 */
class Event extends ActiveRecord
{
	/**
	 * @return object
	 */
	public static function model() {
		return parent::model(__CLASS__);
	}
	
	/**
	 * @return string Table name
	 */
	public function tableName() {
		return '{{event}}';
	}
	
	/**
	 * Relations
	 *
	 */
	public function relations() {
		return array(
			'club' => array(self::BELONGS_TO, 'Club', 'club_id'),
			'galleries' => array(self::HAS_MANY, 'Gallery', 'event_id'),
			'countGalleries' => array(self::STAT, 'Gallery', 'event_id'),
		);
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'title' => Yii::t('event', 'Title'),
			'location' => Yii::t('event', 'Location'),
			'date' => Yii::t('event', 'Date'),
			'description' => Yii::t('event', 'Description'),
			'content' => Yii::t('event', 'Content'),
			'club_id' => Yii::t('event', 'Club'),
			'cover' => Yii::t('event', 'Cover Image'),
			'is_public' => Yii::t('event', 'Is Active'),
		);
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			array('title, date, cover', 'required' ),
			array('title', 'length', 'min' => 3, 'max' => 55 ),
			array('is_public, location, description, content, club_id', 'safe' ),
		);
	}
	
	/**
	 * Return club list
	 *
	 *
	 */
	public function getEventsList() {
		// Get event list and order by name
		$events = Event::model()->byName()->findAll();
		$list = array();
		foreach($events as $event) {
			$list[$event->id] = $event->name;
		}
		
		return $list;
	}
	
	public function getEventListByClub() {
		$list = array();
		$clubs = Club::model()->findAll();
		foreach($clubs as $club) {
			$events = array();
			foreach($club->events as $event) {
				$events[$event->id] = $event->title;
			}
			$list[$club->name] = $events;
		}
		
		return $list;
	}
	
	/**
	 * Model scopes
	 *
	 */
	public function scopes() {
		return array(
			'byName' => array(
				'order' => 't.title ASC',
			),
			'byDate' => array(
				'order' => 't.date DESC',
			),
			'byDateAsc' => array(
				'order' => 't.date ASC',
			),
			'byRand' => array(
				'order' => 'RAND()',
			),
			'byCreatedDate' => array(
				'order' => 't.created_date DESC',
			),
			'upcoming' => array(
				'condition' => 't.date > :time',
				'params' => array(':time' => time()),
			),
			'byClub' => array(
				'group' => 't.club_id',
			),
			'isPublic' => array(
				'condition' => 't.is_public=:status',
				'params' => array(':status' => 1),
			),
		);
	}
	
	/**
	 * Return limit records
	 */
	public function limit($limit=5) {
	    $this->getDbCriteria()->mergeWith(array(
	        'limit'=>$limit,
	    ));
	    return $this;
	}
	
	/**
	 * before save
	 */
	public function beforeSave() {
		// Make an alias
		$this->alias = Yii::app()->func->makeAlias($this->title);
		
		// Modify the event date into timestamp
		if($this->date) {
			// Convert event date into unix
			$date = explode('/', $this->date);
			if(count($date) == 3) {
				$this->date = mktime(0, 0, 0, $date[0], $date[1], $date[2]);	
			}
		}
		
		// Run parent
		return parent::beforeSave();
	}
	
	/**
	 * Return date for display
	 */
	public function getDateForDisplay() {
		return Yii::app()->dateFormatter->format('EEE, M/d/yyyy', $this->date);
	}
	
	/**
	 * Return location for display
	 */
	public function getLocationForDisplay() {
		return $this->location ? $this->location : '--';
	}
	
	/**
	 * Return if club assigned
	 */
	public function hasClub() {
		return $this->club_id && $this->club ? true : false;
	}
	
	/**
	 * Return the event date
	 *
	 */
	public function getEventDate() {
		return $this->date ? date('m/d/Y', $this->date) : '';
	}
	
	/**
	 * Return event link
	 */
	public function getLink() {
		return 'event/' . $this->id . '-' . $this->alias;
	}
	
	/**
	 * before delete
	 */
	public function beforeDelete() {
		
		// Return
		return parent::beforeDelete();
	}
}