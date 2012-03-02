<?php

// Load rackspace class
require_once( Yii::getPathOfAlias('ext.rackspace.rackspace-php-cloudfiles.cloudfiles') . '.php' );

/**
 * Wrapper class for the rackspace files API
 *
 */
class RackspaceFiles {
	/**
	 * @var string - rackspace api username
	 */
	public $username;
	/**
	 * @var string - rackspace api key
	 */
	public $api_key;
	/**
	 * @var string - rackspace class CF_Auth
	 */
	protected $auth;
	/**
	 * @var string - rackspace class CF_Connection
	 */
	protected $connection;
	
	/**
	 * Class constructor
	 * @param string $username
	 * @param string $api_key
	 */
	public function __construct($username=null, $api_key=null) {
		if(!is_null($username)) {
			$this->username = $username;
		}
		
		if(!is_null($api_key)) {
			$this->api_key = $api_key;
		}
	}
	
	/**
	 * Auth and connect to rackspace
	 * @return object CF_Connection
	 */
	public function connect() {
		$this->auth = new CF_Authentication($this->username, $this->api_key);
		$this->auth->ssl_use_cabundle();  # bypass cURL's old CA bundle
		$this->auth->authenticate();
		
		$this->connection = new CF_Connection($this->auth);
		$this->connection->ssl_use_cabundle();
		
		return $this->connection;
	}
	
	/**
	 * Create container
	 * @param string $name
	 * @param boolean $public
	 * @param int $ttl
	 *
	 */
	public function createContainer($name, $public=false, $ttl=86400) {
		$container = $this->connection->create_container($name);
		if($public) {
			return $container->make_public($ttl);
		}
		
		return true;
	}
	
	/**
	 * Upload an object to a container
	 * @param string $container 
	 * @param string $path
	 * @param string $file
	 * @return string
	 */
	public function uploadObject($container, $path, $file) {
		// Make sure container exists
		$cf = $this->connection->get_container($container);
	
		// Create paths to object
		$cf->create_paths($path);
		
		// Maybe we have that object already so try to delete it first
		try {
			$cf->delete_object($path);
		} catch (Exception $e) {}
		
		// Create object
		$object = $cf->create_object($path);
		
		// Upload it
		$object->load_from_filename($file);
		
		return $object->public_uri();
	}
	
	/**
	 * Delete objects inside of a container
	 * @param string $container
	 * @param string $path 
	 * @return int number of deleted objects
	 */
	public function deleteObjects($container, $path=null) {
		$cf = $this->connection->get_container($container);

		$files = $cf->list_objects(0, null, null, $path);
		
		if(count($files)) {
			foreach($files as $file) {
				$cf->delete_object($file);
			}
			
			if($path) {
				// Now delete the master path
				$cf->delete_object($path);		
			}
		}
		
		return count($files)+1;
	}
	
	/**
	 * Return the CF_Auth instance
	 * @return object CF_Auth
	 */
	public function getAuth() {
		return $this->auth;
	}
	
	/**
	 * Return the CF_Connection instance
	 * @return object CF_Connection
	 */
	public function getConnection() {
		return $this->connection;
	}
	
	
}