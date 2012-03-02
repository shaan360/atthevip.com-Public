<?php
/**
 * gallery model
 */
class Gallery extends ActiveRecord
{
	public $createContainer = false;
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
		return '{{gallery}}';
	}
	
	/**
	 * Relations
	 *
	 */
	public function relations() {
		return array(
			'club' => array(self::BELONGS_TO, 'Club', 'club_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'container' => array(self::BELONGS_TO, 'MediaContainer', 'container_id'),
			'images' => array(self::HAS_MANY, 'GalleryImage', 'gallery_id', 'order' => 'images.order ASC'),
			'visibleImages' => array(self::HAS_MANY, 'GalleryImage', 'gallery_id', 'order' => 'visibleImages.order ASC', 'condition' => 'visibleImages.is_public=1'),
			'visibleRandomImages' => array(self::HAS_MANY, 'GalleryImage', 'gallery_id', 'order' => 'RAND()', 'limit' => 2, 'condition' => 'visibleRandomImages.is_public=1'),
			'countVisibleImages' => array(self::STAT, 'GalleryImage', 'gallery_id', 'order' => 't.order ASC', 'condition' => 't.is_public=1'),
			'countImages' => array(self::STAT, 'GalleryImage', 'gallery_id'),
			'coverObject' => array(self::BELONGS_TO, 'GalleryImage', 'cover'),
		);
	}

	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('gallery', 'Name'),
			'location' => Yii::t('gallery', 'Location'),
			'club_id' => Yii::t('gallery', 'Club'),
			'event_id' => Yii::t('gallery', 'Event'),
			'event_date' => Yii::t('gallery', 'Event Date'),
			'container_id' => Yii::t('gallery', 'Container'),
			'presented_by' => Yii::t('gallery', 'Presented By'),
			'taken_by' => Yii::t('gallery', 'Taken By'),
			'cover' => Yii::t('gallery', 'Album Cover'),
			'is_public' => Yii::t('gallery', 'Is Active'),
			'watermark_logo' => Yii::t('gallery', 'Watermark Site Logo'),
			'watermark_club_logo' => Yii::t('gallery', 'Watermark Club Logo'),
		);
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			array('name', 'required' ),
			array('name', 'length', 'min' => 3, 'max' => 55 ),
			array('watermark_logo, watermark_club_logo, is_public, location, club_id, event_id, event_date, container_id, presented_by, taken_by, cover', 'safe' ),
		);
	}
	
	public function getVisibleRandom($total=5) {
		$count = 0;
		$list = array();
		foreach($this->visibleRandomImages as $image) {
			if($count >= $total) {
				return $list;
			}
			
			$list[] = $image;
			$count++;
		}
		
		return $list;
	}
	
	public function sumImagesSize() {
		if( ($sum = Yii::app()->cache->get('galleryimagesizesummry_'.$this->id)) === false ) {
			$sum = 0;
			foreach($this->images as $image) {
				$sizes = array('tiny', 'small', 'medium', 'large');
				foreach($sizes as $size) {
					$value = $image->$size;
					if($value) {
						$sum += $value->size;
					}
				}
			}
			$dependency = new CDbCacheDependency('SELECT COUNT(id) FROM gallery_image WHERE gallery_id='.$this->id);
			Yii::app()->cache->set('galleryimagesizesummry_'.$this->id, $sum, 60 * 60 * 24, $dependency);
		}
		
		return $sum;
	}
	
	/**
	 * before save
	 */
	public function beforeSave() {
		// Make an alias
		$this->alias = Yii::app()->func->makeAlias($this->name);
		
		// Do we need to create a new container
		if($this->container_id == '') {
			// Create new container with the name 'gallery_id'
			$this->createContainer = true;
		}
		
		// Modify the event date into timestamp
		if($this->event_date) {
			// Convert event date into unix
			$date = explode('/', $this->event_date);
			if(count($date) == 3) {
				$this->event_date = mktime(0, 0, 0, $date[0], $date[1], $date[2]);	
			}
		}
		
		// Run parent
		return parent::beforeSave();
	}
	
	/**
	 * Return date for display
	 */
	public function getDateForDisplay() {
		return Yii::app()->dateFormatter->format('EEE, M/d/yyyy', $this->event_date);
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
	 * Model scopes
	 *
	 */
	public function scopes() {
		return array(
			'byName' => array(
				'order' => 't.name ASC',
			),
			'byDate' => array(
				'order' => 't.event_date DESC',
			),
			'byDateAsc' => array(
				'order' => 't.event_date ASC',
			),
			'byDateDesc' => array(
				'order' => 't.created_date DESC',
			),
			'byRand' => array(
				'order' => 'RAND()',
			),
			'byCreatedDate' => array(
				'order' => 't.created_date DESC',
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
	 * Return event date
	 *
	 */
	public function getEventDate() {
		return $this->event_date ? date('m/d/Y', $this->event_date) : '';
	}
	
	/**
	 * before save
	 */
	public function afterSave() {
		// do we need to create a container?
		if($this->createContainer) {
			$container = new MediaContainer;
			$container->name = 'gallery_' . $this->id;
			$container->is_public = 1;
			$container->save();
			
			// Update our record
			Gallery::model()->updateByPk($this->id, array('container_id' => $container->id));
		}
		
		// Run parent
		return parent::afterSave();
	}
	
	/**
	 * Return gallery link
	 */
	public function getLink() {
		return 'gallery/' . $this->id . '-' . $this->alias;
	}
	
	/**
	 * before delete
	 */
	public function beforeDelete() {
		
		// Return
		return parent::beforeDelete();
	}
}