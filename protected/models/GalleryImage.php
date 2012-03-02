<?php
/**
 * gallery image model
 */
class GalleryImage extends ActiveRecord
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
		return '{{gallery_image}}';
	}
	
	/**
	 * Relations
	 *
	 */
	public function relations() {
		return array(
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
			'tiny' => array(self::BELONGS_TO, 'MediaObject', 'tiny_object_id'),
			'small' => array(self::BELONGS_TO, 'MediaObject', 'small_object_id'),
			'medium' => array(self::BELONGS_TO, 'MediaObject', 'medium_object_id'),
			'large' => array(self::BELONGS_TO, 'MediaObject', 'large_object_id'),
		);
	}
	
	public function scopes() {
		return array(
			'isActive' => array(
				'condition' => 'gallery_image.is_public=:public',
				'params' => array(':public' => 1),
			),
			'byDate' => array(
				'order' => 'created_date ASC',
			),
		);
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			array('gallery_id, tiny_object_id, small_object_id, medium_object_id, large_object_id, is_public, comment', 'safe' ),
		);
	}
}