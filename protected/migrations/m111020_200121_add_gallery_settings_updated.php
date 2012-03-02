<?php

class m111020_200121_add_gallery_settings_updated extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('gallery', 'watermark_logo');
		$this->dropColumn('gallery', 'watermark_club_logo');
	
		$this->addColumn('gallery', 'watermark_logo', 'tinyint(1) NOT NULL default "1"');
		$this->addColumn('gallery', 'watermark_club_logo', 'tinyint(1) NOT NULL default "1"');
	}

	public function down()
	{
		echo "m111020_200121_add_gallery_settings_updated does not support migration down.\n";
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