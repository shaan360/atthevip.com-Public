<?php

class m111020_195406_add_gallery_settings extends CDbMigration
{
	public function up()
	{
		$this->addColumn('gallery', 'watermark_logo', 'tinyint(1)');
		$this->addColumn('gallery', 'watermark_club_logo', 'tinyint(1)');
	}

	public function down()
	{
		echo "m111020_195406_add_gallery_settings does not support migration down.\n";
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