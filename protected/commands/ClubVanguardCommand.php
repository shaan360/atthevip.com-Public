<?php
/**
 * Vanguard event importer
 *
 */

require_once( Yii::getPathOfAlias('application.extensions.simplehtmldom') . '/simple_html_dom.php'); 
 
class ClubVanguardCommand extends CConsoleCommand {
    public $eventsHomePage = 'http://www.vanguardla.com.php5-11.websitetestlink.com/sample-page-2/';
    public $eventLinks = array();
    public $commandName = 'ClubVanguardCommand.php';
    public function actionIndex() {
    	// Get links
    	$this->showMsg("Starting Import: " . get_class($this));
    	$this->getEventLinks();
  		if(count($this->eventLinks)) {
  			foreach($this->eventLinks as $eventLink) {
  				$this->getEventLink($eventLink);
  			}
  		}
  		$this->showMsg("Import Finished: " . get_class($this));
    }
    
    protected function getEventLink($link) {
    	// Extract the link from the tag
    	preg_match('#href=\"(.*?)\"#', $link, $match);
    	if(!count($match)) {
    		return;
    	}
    	
    	// New link
    	$eventLink = $match[1];
  		
  		// Load data
  		$html = file_get_html($eventLink);
  		
  		// Prepare
  		$event = array();
  		
		// get title
		foreach($html->find('div.display_name') as $e) {
			$event['title'] = $e->plaintext;
		}
		
		// get date
		foreach($html->find('div.datehour') as $e) {
			$eventdate = $e->find('p', 0)->plaintext;
			
			// Explode and get 4 first elements 
			$exploded = explode(' ', $eventdate);
			$newdate = $exploded[0] . ' ' . $exploded[1] . ' ' . $exploded[2] . ' ' . intval($exploded[3]); 
			$event['date'] = $newdate;
			$event['date_unix'] = strtotime($newdate);
			$event['date_makesure'] = date('m/d/Y', $event['date_unix']);
			break;
		}
		
		// Grab small image link
		foreach($html->find('div.event_pic') as $e) {
			foreach($e->find('img') as $img) {
				$event['small_cover'] = $img->src;	
			}
		}
		
		// Grab large image
		foreach($html->find('div#customized') as $k) {
			foreach($k->find('p') as $p) {
				foreach($p->find('img') as $limg) {
					$event['large_cover'] = $limg->src;
					break 3;	
				}
			}
		}
		
		// Grab content
		foreach($html->find('div#event_details') as $r) {
			$event['content'] = $r->innertext;
		}
		
		// Grab description
		foreach($html->find('div.whowhere') as $w) {
			foreach($w->find('h4') as $h) {
				$event['description'] = $h->plaintext;
			}
		}
		
		// Make sure we have a title
		if(!$event['title']) {
			$this->showMsg("No title was matched for the event.");
			return;
		}
		
		// Grab the club id
		$club = Club::model()->find('importer_file=:name', array(':name' => $this->commandName));
		
		if(!$club) {
			$this->showMsg("Club does not exists;");
			return;
		}
		
		// Based on event date
		if($event['date_unix']) {
			// Do we have an event with that name for this club?
			$findEvent = Event::model()->find('title=:title AND club_id=:id AND date=:eventdate', array(':eventdate' => $event['date_unix'], ':title' => $event['title'], ':id' => $club->id));
		} else {
			// Do we have an event with that name for this club?
			$findEvent = Event::model()->find('title=:title AND club_id=:id', array(':title' => $event['title'], ':id' => $club->id));
		}
		
		// If event exists then do not import
		if($findEvent) {
			$this->showMsg(sprintf("The event '%s' already exists in this club.", $event['title']));
			return;
		}
		
    	// Add the event to the db if we don't have it yet
    	$newEvent = new Event;
    	$newEvent->title = $event['title'];
    	$newEvent->club_id = $club->id;
    	$newEvent->date = $event['date_unix'] ? $event['date_unix'] : time();
    	$newEvent->is_public = $event['date_unix'] ? 1 : 0;
    	$newEvent->description = $event['description'];
    	//$newEvent->content = $event['content'] . ('<p>'. CHtml::image($event['large_cover'], 'cover') . '</p>');
    	$newEvent->content = $event['content'] . ('<p>Source: <a href="http://vanguardla.com">Vanguardla.com</a></p>');
    	$newEvent->cover = $event['small_cover'];
    	$newEvent->large_cover = $event['large_cover'];
    	$newEvent->save(false);
    	
    	$this->showMsg(sprintf("--- Event '%s' Saved. ----", $event['title']));
    	
    	
    }
    
    protected function showMsg($msg) {
    	echo $msg."\n";
    	Yii::log($msg, 'console');
    }
    
    protected function getEventLinks() {
    	// We access the events home page and grab all the 
    	// upcoming events
    	$contents = file_get_contents($this->eventsHomePage);
    	// Don't have anything
    	if(!$contents) {
    		return false;
    	}
    	
    	// Parse the contents and grab the actual event links
    	preg_match_all('#<div class=\"cal_show_thumb\"[^>]*>(.*?)</div>#s', $contents, $matches);
    	
    	if($matches) {
    		$this->eventLinks = $matches[1];
    	}
    	
    }
    
}