<?php
/**
 * Media objects
 */
class MediaObject extends ActiveRecord
{
	public $file;
	public $realName;
	
	public static $rackspace = null;
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
		return '{{media_objects}}';
	}
	
	/**
	 * Get rackspace object
	 *
	 */
	public function getRackSpace() {
		if(self::$rackspace !== null) {
			return self::$rackspace;
		}
		
		// Make sure it works
		if(getParam('rackspace_username') && getParam('rackspace_api_key')) {
			// Load the classes
			Yii::import('ext.RackspaceFiles');
			self::$rackspace = new RackspaceFiles(getParam('rackspace_username'), getParam('rackspace_api_key'));
			try {
				self::$rackspace->connect();
			} catch (Exception $e) {
				self::$rackspace = null; // reset
			}
		}
		
		return self::$rackspace;
	}
	
	/**
	 * Relations
	 *
	 */
	public function relations() {
		return array(
		    'container' => array(self::BELONGS_TO, 'MediaContainer', 'container_id'),
		);
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'name' => Yii::t('media', 'Object Name'),
			'is_active' => Yii::t('media', 'Is Active'),
			'container_id' => Yii::t('media', 'Container'),
			'file' => Yii::t('media', 'Object'),
		);
	}
	
	/**
	 * before save
	 */
	public function beforeSave() {
		// Create a container
		if($this->file) {
			$usedName = $this->realName ? $this->realName : $this->file->getName();
			
			// Update variables
			$this->size = $this->file->getSize();
			$this->type = $this->file->getType();
			$this->ext = $this->getExt($usedName);
			
			if($this->isNewRecord) {
				// Object name
				$this->name = sprintf("%s_%s_%s_%s", Yii::app()->func->makeAlias($this->container->name), date('m_d_Y'), substr(sha1(microtime(true)), 35, 5), $this->createName($usedName));
			}
			
			// Upload file to the cloud
			$link = $this->getRackSpace()->uploadObject($this->container->name, $this->name, $this->file->getTempName());
			$this->object_link = $link;
			
			// If this is not a new record we need to update cdn
			if(!$this->isNewRecord) {
				$this->updateObjectCDN();
				$this->container->updateContainerCDN();
			}
		}
		return parent::beforeSave();
	}
	
	/**
	 * Create file name
	 *
	 */
	public function createName($name) {
		$clean = Yii::app()->func->makeAlias($name);
		$ext = MediaObject::model()->getExt($name);
		return $clean . '.' . $ext;
	}
	
	/**
	 * Get file extension by name
	 *
	 */
	public function getExt($file) {
		return strtolower(end(explode('.', $file)));
	}
	
	/**
	 * Update container
	 *
	 */
	public function updateObjectCDN() {
		// Delete object from db
		try {
			$container = $this->getRackspace()->getConnection()->get_container($this->container->name);
			$obj = $container->get_object($this->name);
			$obj->purge_from_cdn();
		} catch (Exception $e) {
			// Nothing	
		}
	}
	
	/**
	 * before delete
	 */
	public function beforeDelete() {
		// Delete object from db
		try {
			$container = $this->getRackspace()->getConnection()->get_container($this->container->name);
			$container->delete_object($this->name);
		} catch (Exception $e) {
			// Nothing	
		}
		
		// Delete container from cloud
		return parent::beforeDelete();
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules() {
		return array(
			array('container_id', 'required' ),
			//array('name', 'match', 'allowEmpty'=>false, 'pattern'=>'/[A-Za-z0-9]+$/'),
			//array('name', 'unique'),
			//array('name', 'length', 'min' => 3, 'max' => 55 ),
			array('is_active', 'safe' ),
			array('file', 'file', 'allowEmpty' => false, 'maxSize' => getParam('object_max_size') ? getParam('object_max_size') : null, 'types' => getParam('object_types') ? getParam('object_types') : null),
		);
	}
}