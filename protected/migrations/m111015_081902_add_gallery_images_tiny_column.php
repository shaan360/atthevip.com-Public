<?php

class m111015_081902_add_gallery_images_tiny_column extends CDbMigration
{
	public function up()
	{
		$this->addColumn('gallery_image', 'tiny_object_id', "int");
	}

	public function down()
	{
		echo "m111015_081902_add_gallery_images_tiny_column does not support migration down.\n";
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