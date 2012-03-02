<?php

class m111014_191047_add_gallery_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('gallery', array(
			'id' => 'pk',
			'name' => 'string',
			'alias' => 'string',
			'location' => 'text',
			'club_id' => 'int',
			'event_id' => 'int',
			'event_date' => 'int',
			'container_id' => 'int',
			'presented_by' => 'string',
			'taken_by' => 'string',
			'cover' => 'string',
			'created_date' => 'int',
			'created_user' => 'int',
			'is_public' => 'tinyint(1) NOT NULL default "0"',
		));
	}

	public function down()
	{
		echo "m111014_191047_add_gallery_table does not support migration down.\n";
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