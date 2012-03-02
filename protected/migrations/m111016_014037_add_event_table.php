<?php

class m111016_014037_add_event_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('event', array(
			'id' => 'pk',
			'title' => 'string',
			'alias' => 'string',
			'date' => 'int',
			'description' => 'string',
			'content' => 'text',
			'club_id' => 'int',
			'location' => 'string',
			'cover' => 'string',
			'created_date' => 'int',
			'created_user' => 'int',
			'is_public' => 'tinyint(1) NOT NULL default "0"',
		));

	}

	public function down()
	{
		echo "m111016_014037_add_event_table does not support migration down.\n";
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