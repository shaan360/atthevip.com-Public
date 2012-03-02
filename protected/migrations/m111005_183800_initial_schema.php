<?php

class m111005_183800_initial_schema extends CDbMigration
{
	public function up()
	{
		$q = file_get_contents( Yii::getPathOfAlias('application.data') . '/schema.sql' );
		if($q) {
			try {
				$this->execute($q);
			} catch(CException $e) {
				echo $e->getMessage();
			}
		}
		
	}

	public function down()
	{
		echo "m111005_183800_initial_schema does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}