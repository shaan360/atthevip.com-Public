<?php

class m111005_184809_media_manager_schema extends CDbMigration
{
	public function up()
	{
		$this->createTable('media_containers', array(
			'id' => 'pk',
			'name' => 'string',
			'files' => 'int',
			'total_size' => 'int',
			'created_date' => 'int',
			'created_user' => 'int',
			'is_public' => 'tinyint(1) NOT NULL default "0"',
		));
		
		$this->createTable('media_objects', array(
			'id' => 'pk',
			'name' => 'string',
			'path' => 'string',
			'container' => 'int',
			'size' => 'int',
			'ext' => 'string',
			'type' => 'string',
			'is_active' => 'int',
			'created_date' => 'int',
			'created_user' => 'int',
		));
	}

	public function down()
	{
		echo "m111005_184809_media_manager_schema does not support migration down.\n";
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