<?php
/**
 * Media containers
 */
class MediaContainer extends ActiveRecord
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
		return '{{media_containers}}';
	}
	
	/**
	 * Get rackspace object
	 *
	 */
	public function getRackSpace() {
		$rackspace = null;
		
		// Make sure it works
		if(getParam('rackspace_username') && getParam('rackspace_api_key')) {
			// Load the classes
			Yii::import('ext.RackspaceFiles');
			$rackspace = new RackspaceFiles(getParam('rackspace_username'), getParam('rackspace_api_key'));
			try {
				$rackspace->connect();
			} catch (Exception $e) {
				$rackspace = null; // reset
			}
		}
		
		return $rackspace;
	}
	
	/**
	 * Relations
	 *
	 */
	public function relations() {
		return array(
		    'objects' => array(self::HAS_MANY, 'MediaObject', 'container_id'),
		    'objectCount' => array(self::STAT, 'MediaObject', 'container_id'),
		);
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('media', 'Container Name'),
			'is_public' => Yii::t('media', 'Is Public'),
			'container_url' => Yii::t('media', 'Container URL'),
		);
	}
	
	/**
	 * Return a list of containers
	 *
	 */
	public function getContainerList() {
		$rows = MediaContainer::model()->byName()->findAll();
		$list = array();
		foreach($rows as $row) {
			$list[$row->id] = $row->name;
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
			'byDate' => array(
				'order' => 'created_date DESC',
			),
		);
	}
	
	/**
	 * before save
	 */
	public function beforeSave() {
		if($this->isNewRecord) {
			// Create a container
			$return = $this->getRackSpace()->createContainer($this->name, $this->is_public);
			if($return) {
				// Update db
				if($this->is_public) {
					$this->container_url = $return;
				}
			}
		} else {
			try {
				if(!$this->is_public) {
					// Update private
					$container = $this->getRackSpace()->getConnection()->get_container($this->name);
					if($container) {
						$container->make_private();
						$container_url = '';
					}
				} else {
					// Update private
					$container = $this->getRackSpace()->getConnection()->get_container($this->name);
					if($container) {
						$container_url = $container->make_public();
					}
				}
				
				$this->container_url = $container_url;
				
			} catch (Exception $e) {}
		}
	
		$this->updateContainerInfo($this->name);
		
		// Run parent
		return parent::beforeSave();
	}
	
	/**
	 * Update container info
	 *
	 */
	public function updateContainerInfo($id) {
		// Update files count and size from container
		try {
			$record = self::model()->findByPk($id);
			if($record) {
				$container = $this->getRackSpace()->getConnection()->get_container($record->name);
				if($container) {
					// Update files and total_size
					$record->files = $container->object_count;
					$record->total_size = $container->bytes_used;
					$record->update();
				}
			}
		} catch(Exception $e) {}
	}
	
	/**
	 * Update container
	 *
	 */
	public function updateContainerCDN() {
		// Delete object from db
		try {
			$container = $this->getRackspace()->getConnection()->get_container($this->container->name);
			$container->purge_from_cdn();
		} catch (Exception $e) {
			// Nothing	
		}
	}
	
	/**
	 * before delete
	 */
	public function beforeDelete() {
		// Delete container from cloud
		try {
			$this->getRackspace()->deleteObjects($this->name);
			$this->getRackSpace()->getConnection()->delete_container($this->name);
		} catch (Exception $e) {
			// Nothing	
		}
		
		// Delete all objects from db
		foreach($this->objects as $obj) {
			$obj->delete();
		}
		
		// Return
		return parent::beforeDelete();
	}
	
	/**
	 * Get containers list
	 *
	 */
	public function getContainersList() {
		if( ($containers = Yii::app()->cache->get('containers_list')) === false ) {
			$containers = $this->getRackSpace()->getConnection()->list_containers();
			Yii::app()->cache->set('containers_list', $containers);
		}
		
		return $containers;
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			array('name', 'required' ),
			array('name', 'match', 'allowEmpty'=>false, 'pattern'=>'/[A-Za-z0-9]+$/'),
			array('name', 'unique'),
			array('name', 'length', 'min' => 3, 'max' => 55 ),
			array('is_public, container_url', 'safe' ),
		);
	}
}