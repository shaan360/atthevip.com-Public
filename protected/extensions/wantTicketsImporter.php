<?php
require_once( Yii::getPathOfAlias('application.extensions.simplehtmldom') . '/simple_html_dom.php'); 
 
class wantTicketsImporter {
	public $link = '';
	public $html;
	public $host = 'http://wantickets.com';
	public static $rackspace = null;
	public function __construct($link=null) {
		if($link) {
			$this->link = $link;
		}
		
		$this->html = file_get_html($this->link);
		
	}
	
	public function getEvents() {
		$eventLinks = $this->getEventLinks();
		$events = array();
		// For each link open up and get info
		foreach($eventLinks as $event) {
			$html = file_get_html($event);
			$data = array();
			// Get title
			foreach($html->find('div#divEventInfoMain h1') as $t) {
				$usedtitle = explode('@', trim($t->plaintext));
				if(count($usedtitle) > 1) {
					$data['title'] = $usedtitle[0];
				} else {
					$data['title'] = trim($t->plaintext);
				}
			}
			
			// Get small and large cover
			foreach($html->find('div#eventThumbnailWrapper div#siteFileImageWrapper a img') as $i) {
				$data['small_cover'] = $this->rebuildImageLink(trim($i->src));
			}
			
			foreach($html->find('div#eventFlyerSection div#siteFileImageWrapper a img') as $v) {
				$data['large_cover'] = $this->rebuildImageLink(trim($v->src));
			}
			
			// Get date
			foreach($html->find('div#eventDate div.EventInfoBoxContent') as $d) {
				$date = trim($d->plaintext);
				$exploded_date = explode(' - ', $date);
				$data['event_date'] = $date;
				if(count($exploded_date) > 1) {
					$data['event_date_unix'] = strtotime($exploded_date[0]);
				} else {
					$data['event_date_unix'] = strtotime($date);
				}
				$data['event_date_human'] = date('m/d/Y', $data['event_date_unix']);
			}
			
			// get Content
			foreach($html->find('div#divMainEventDescription div.FieldValue') as $c) {
				$data['content'] = $c->innertext;
				$data['description'] = substr(trim($c->plaintext), 0, 220);
			}
			
			$container_name = 'clubs';
			$containerobj = MediaContainer::model()->find('name=:name', array(':name' => $container_name));
			$containerid = 0;
			if($containerobj) {
				$containerid = $containerobj->id;
			}
			
			// Import small and large cover
			if(isset($data['small_cover'])) {
				// Upload images to our servers
				$usedName = Yii::app()->func->makeAlias($data['title']);
				
				// Update variables
				$size = @filesize($data['small_cover']);
				$type = 'image/jpeg';
				$ext = MediaObject::model()->getExt($data['small_cover']);
				$name = sprintf("%s_%s_%s_%s", Yii::app()->func->makeAlias($container_name), date('m_d_Y'), substr(sha1(microtime(true)), 35, 5), (substr($usedName, 0, 40) . '.' . $ext));
				
				// Upload file to the cloud
				$rackspace = $this->getRackSpace()->getConnection();
				$containerObject = $rackspace->get_container($container_name);
				$newmedia = $containerObject->create_object(preg_replace('/[^a-zA-Z0-9\.\-\_]/', '', $name));
   				$newmedia->write(file_get_contents($data['small_cover']));
				
				$object_link = $newmedia->public_uri();;
				
				$mediaObject = new MediaObject;
				$mediaObject->size = $size;
				$mediaObject->type = $type;
				$mediaObject->ext = $ext;
				$mediaObject->name = $name;
				$mediaObject->object_link = $object_link;
				$mediaObject->container_id = $containerid;
				$mediaObject->is_active = 1;
				if($mediaObject->save(false)) {
					$data['small_cover'] = $object_link;
				} else {
					$data['media_errors'] = $mediaObject->getErrors();
				}
			}
			
			// Import small and large cover
			if(isset($data['large_cover'])) {
				// Upload images to our servers
				$usedName = Yii::app()->func->makeAlias($data['title']);
				
				// Update variables
				$size = @filesize($data['large_cover']);
				$type = 'image/jpeg';
				$ext = MediaObject::model()->getExt($data['large_cover']);
				$name = sprintf("%s_%s_%s_%s", Yii::app()->func->makeAlias($container_name), date('m_d_Y'), substr(sha1(microtime(true)), 35, 5), (substr($usedName, 0, 40) . '.' . $ext));
				
				// Upload file to the cloud
				$rackspace = $this->getRackSpace()->getConnection();
				$containerObject = $rackspace->get_container($container_name);
				$newmedia = $containerObject->create_object(preg_replace('/[^a-zA-Z0-9\.\-\_]/', '', $name));
   				$newmedia->write(file_get_contents($data['large_cover']));
				
				$object_link = $newmedia->public_uri();;
				
				$mediaObject = new MediaObject;
				$mediaObject->size = $size;
				$mediaObject->type = $type;
				$mediaObject->ext = $ext;
				$mediaObject->name = $name;
				$mediaObject->object_link = $object_link;
				$mediaObject->container_id = $containerid;
				$mediaObject->is_active = 1;
				if($mediaObject->save(false)) {
					$data['large_cover'] = $object_link;
				} else {
					$data['media_errors'] = $mediaObject->getErrors();
				}
			}
			
			// Add
			$events[] = $data;
			
		}
		
		
		return $events;
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
	
	public function rebuildImageLink($link) {
		$parts = parse_url($link);
		// Explode query
		$query = explode('&amp;', $parts['query']);
		$queryparts = array();
		foreach($query as $q) {
			// Skip unwanted values
			if($this->skipImageUrlParts($q)) {
				continue;
			}
			$queryparts[] = $q;
		}
		
		return $parts['scheme'] . '://' . $parts['host'] . $parts['path'] . '?' . implode('&amp;', $queryparts);
	}
	
	public function skipImageUrlParts($q) {
		if(strpos($q, 'maxWidth=') !== false) {
			return true;
		} elseif(strpos($q, 'maxHeight=') !== false) {
			return true;
		} elseif(strpos($q, 'maxKb=') !== false) {
			return true;
		} elseif(strpos($q, 'cropImage=') !== false) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getEventLinks() {
		$links = array();
		foreach($this->html->find('div.EventMappedItemResults') as $e) {
			foreach($e->find('div.EventInfo a') as $k) {
				$links[] = $this->host . $k->href;	
			}
		}
		
		return $links;
	}
}