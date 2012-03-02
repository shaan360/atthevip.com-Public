<?php
/**
 * premiere event importer
 *
 */

require_once( Yii::getPathOfAlias('application.extensions') . '/wantTicketsImporter.php'); 
 
class ClubPremiereCommand extends CConsoleCommand {
    public $eventsHomePage = 'http://wantickets.com/Venues/5369/PREMIERE-SUPPER-CLUB/';
    public $eventLinks = array();
    public $commandName = 'ClubPremiereCommand.php';
    public function actionIndex() {
    	// Get links
    	$this->showMsg("Starting Import: " . get_class($this));
    	
    	// Grab the club id
		$club = Club::model()->find('importer_file=:name', array(':name' => $this->commandName));
		
		if(!$club) {
			$this->showMsg("Club does not exists;");
			return;
		}
    	
    	// Get Data from want tickets
    	$wantTickets = new wantTicketsImporter($this->eventsHomePage);
    	$events = $wantTickets->getEvents();
    	
    	foreach($events as $event) {
    		// Make sure we have a title
			if(!isset($event['title'])) {
				$this->showMsg("No title was matched for the event.");
				continue;
			}
			
			// Based on event date
			if($event['event_date_unix']) {
				// Do we have an event with that name for this club?
				$findEvent = Event::model()->find('title=:title AND club_id=:id AND date=:eventdate', array(':eventdate' => $event['event_date_unix'], ':title' => $event['title'], ':id' => $club->id));
			} else {
				// Do we have an event with that name for this club?
				$findEvent = Event::model()->find('title=:title AND club_id=:id', array(':title' => $event['title'], ':id' => $club->id));
			}
			
			// If event exists then do not import
			if($findEvent) {
				$this->showMsg(sprintf("The event '%s' already exists in this club.", $event['title']));
				continue;
			}
			
	    	// Add the event to the db if we don't have it yet
	    	$newEvent = new Event;
	    	$newEvent->title = $event['title'];
	    	$newEvent->club_id = $club->id;
	    	$newEvent->date = $event['event_date_unix'] ? $event['event_date_unix'] : time();
	    	$newEvent->is_public = $event['event_date_unix'] ? 1 : 0;
	    	$newEvent->description = $event['description'];
	    	//$newEvent->content = $event['content'] . ('<p>'. CHtml::image($event['large_cover'], 'cover') . '</p>');
	    	$newEvent->content = $event['content'] . ('<p>Source: <a href="'.$this->eventsHomePage.'">'.$this->eventsHomePage.'</a></p>');
	    	$newEvent->cover = $event['small_cover'];
	    	$newEvent->large_cover = $event['large_cover'];
	    	$newEvent->save(false);
	    	
	    	$this->showMsg(sprintf("--- Event '%s' Saved. ----", $event['title']));
    	}
    	
  		$this->showMsg("Import Finished: " . get_class($this));
    }
    
    protected function showMsg($msg) {
    	echo $msg."\n";
    	Yii::log($msg, 'console');
    }
    
}