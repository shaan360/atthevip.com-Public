<?php

class m111018_164600_add_event_large_cover extends CDbMigration
{
	public function up()
	{
		$this->addColumn('event', 'large_cover', 'string');
	}

	public function down()
	{
		echo "m111018_164600_add_event_large_cover does not support migration down.\n";
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