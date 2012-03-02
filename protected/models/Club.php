<?php
/**
 * Club model
 */
class Club extends ActiveRecord
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
		return '{{club}}';
	}
	
	/**
	 * Relations
	 *
	 */
	public function relations() {
		return array(
			'events' => array(self::HAS_MANY, 'Event', 'club_id'),
			'eventsCount' => array(self::STAT, 'Event', 'club_id'),
		);
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('clubs', 'Name'),
			'location' => Yii::t('clubs', 'Location'),
			'contact_info' => Yii::t('clubs', 'Contact Info'),
			'images' => Yii::t('clubs', 'Images'),
			'description' => Yii::t('clubs', 'Description'),
			'importer_file' => Yii::t('clubs', 'Importer File'),
			'website' => Yii::t('clubs', 'Website URL'),
			'facebook' => Yii::t('clubs', 'Facebook Page URL'),
			'twitter' => Yii::t('clubs', 'Twitter Account Name'),
			'logo' => Yii::t('clubs', 'Logo URL'),
			'watermark' => Yii::t('clubs', 'Watermark URL'),
			'video' => Yii::t('clubs', 'Video Embed Code'),
			'is_public' => Yii::t('clubs', 'Is Active'),
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
			array('is_public, location, contact_info, images, description, importer_file, website, facebook, twitter, logo, watermark, video', 'safe' ),
		);
	}
	
	/**
 	 * Check Club image
 	 */
	public function hasCoverImage() {
		$pics = explode("\n", $this->images);
		return count($pics) > 1 ? true : false;
 	}
 	
 	/**
 	 * Return club cover image
 	 */
 	public function getCoverImage() {
		$pics = explode("\n", $this->images);
		return $pics[0];
 	}
	
	/**
	 * Return club list
	 *
	 *
	 */
	public function getClubsList() {
		// Get club list and order by name
		$clubs = Club::model()->byName()->findAll();
		$list = array();
		foreach($clubs as $club) {
			$list[$club->id] = $club->name;
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
				'order' => 'name ASC',
			),
			'isPublic' => array(
				'condition' => 't.is_public=:status',
				'params' => array(':status' => 1),
			),
		);
	}
	
	/**
	 * Return club link
	 */
	public function getLink() {
		return 'club/' . $this->id . '-' . $this->alias;
	}
	
	/**
	 * before save
	 */
	public function beforeSave() {
		// Make an alias
		$this->alias = Yii::app()->func->makeAlias($this->name);
		
		// Run parent
		return parent::beforeSave();
	}
	
	/**
	 * before delete
	 */
	public function beforeDelete() {
		
		// Return
		return parent::beforeDelete();
	}
}