<?php
/**
 * Custom rules manager class
 *
 * Override to load the routes from the DB rather then a file
 *
 */
class CustomUrlManager extends CUrlManager {
    /**
     * Build the rules from the DB
     */
    protected function processRules() {		
		if( ($urlrules = Yii::app()->cache->get('customurlrules')) === false )
		{
			$dbCommand = Yii::app()->db->createCommand("SELECT alias FROM {{custompages}}")->query();
			$urlRules = $dbCommand->readAll();
			$_more = array();
			foreach($urlRules as $rule)
			{
				$_more[ "/<alias:({$rule['alias']})>" ] = 'site/custompages/index';
			}	
				
			$this->rules = array(
			
				// News
				"/news/<alias>" => 'site/news/viewpost/',
				"/news/category/<alias>" => 'site/news/viewcategory/',
				
				// Events
				"/event/<id:([0-9-]+)>-<alias:([a-zA-z0-9-\.\_]+)>" => 'site/events/viewevent/',
				'/upcoming-events' => 'site/events/upcoming',
				
				// Clubs
				"/club/<id:([0-9-]+)>-<alias:([a-zA-z0-9-\.\_]+)>" => 'site/clubs/viewclub/',
				
				// Contact Us
				"/contact-us" => 'site/contactus/index/',
				
				// Galleries
				"/galleries" => 'site/gallery/index/',
				"/gallery/<id:([0-9-]+)>-<alias:([a-zA-z0-9-\.\_]+)>" => 'site/gallery/viewgallery/',
			
				//-----------------------ADMIN--------------
				"admin" => 'admin/index/index',
				"admin/<_c:([a-zA-z0-9-]+)>" => 'admin/<_c>/index',
	            //"admin/<_c:([a-zA-z0-9-]+)>/<_a:([a-zA-z0-9-]+)>" => 'admin/<_c>/<_a>',
	            "admin/<_c:([a-zA-z0-9-]+)>/<_a:([a-zA-z0-9-\.]+)>/*" => 'admin/<_c>/<_a>/',
				//-----------------------ADMIN--------------
			
				"" => 'site/index/index', 
				"<_c:([a-zA-z0-9-]+)>" => 'site/<_c>/index',
	            //"<_c:([a-zA-z0-9-]+)>/<_a:([a-zA-z0-9-]+)>" => 'site/<_c>/<_a>',
	            "<_c:([a-zA-z0-9-]+)>/<_a:([a-zA-z0-9-]+)>/*" => 'site/<_c>/<_a>/',
            
	            );
		
			$urlrules = array_merge( $_more, $this->rules );
			Yii::app()->cache->set('customurlrules', $urlrules);
		}
		
		$this->rules = $urlrules;

        // Run parent
        parent::processRules();

    }
    
    /**
     * Clear the cache
     *
     */
    public function clearCache() {
    	return Yii::app()->cache->delete('customurlrules');
    }
}
