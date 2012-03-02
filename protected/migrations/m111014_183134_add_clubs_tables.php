<?php

class m111014_183134_add_clubs_tables extends CDbMigration
{
	public function up()
	{
		$this->createTable('club', array(
			'id' => 'pk',
			'name' => 'string',
			'alias' => 'string',
			'location' => 'text',
			'contact_info' => 'text',
			'images' => 'text',
			'description' => 'text',
			'importer_file' => 'string',
			'website' => 'string',
			'facebook' => 'string',
			'twitter' => 'string',
			'logo' => 'string',
			'watermark' => 'string',
			'video' => 'text',
			'created_date' => 'int',
			'created_user' => 'int',
			'is_public' => 'tinyint(1) NOT NULL default "1"',
		));
	}

	public function down()
	{
		echo "m111014_183134_add_clubs_tables does not support migration down.\n";
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