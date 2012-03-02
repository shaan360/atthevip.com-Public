<?php
/**
 * Even importer command
 *
 */
 set_time_limit(0);
 //ini_set('memory_limit', '1024MB');
class EventImportCommand extends CConsoleCommand
{
	public $errorLevels = 'console, error';
	/**
	 * Grab all clubs that the import_file is not empty
	 * look and see if that files exists under the commands dir and run it
	 */
    public function actionIndex() {
    	// Init
    	$commandsPath = Yii::getPathOfAlias('application.commands');
    	$applicationPath = Yii::getPathOfAlias('application');
    	
    	$this->showMsg('Event Import Start');
    	
    	$clubs = Club::model()->findAll('importer_file IS NOT NULL');
    	
    	// No clubs
    	if(!$clubs) {
    		$this->showMsg('No clubs found.');
    		return;
    	}
    	
    	// Loop all clubs
    	foreach($clubs as $club) {
    		// Command file
    		$commandFile = $commandsPath . '/' . $club->importer_file;
    		
    		// Make sure we have that file under our directory
    		if(!file_exists($commandFile)) {
    			$this->showMsg('File was not found for ' . $commandFile, $this->errorLevels);
    			continue;
    		}
    		
    		// Command name
    		$commandName = strtolower(str_replace(array('Command', '.php'), array('', ''), $club->importer_file));
    		
    		$this->showMsg('Running ' . $commandName . ' ...');
    		
    		// Command 
    		$commandToRun = sprintf("LANG=\"en_US.UTF8\" php %s/yiic.php %s", $applicationPath, $commandName);
    		exec($commandToRun, $out);
    		foreach($out as $print) {
    			$this->showMsg($print);
    		}
    	}
    	
    	$this->showMsg('Event Import End');
    }
    
    protected function showMsg($msg) {
    	echo $msg."\n";
    	Yii::log($msg, $this->errorLevels);
    }
}