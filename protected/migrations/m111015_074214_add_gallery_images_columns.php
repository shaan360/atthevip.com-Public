<?php

class m111015_074214_add_gallery_images_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn('gallery_image', 'comment', 'text');
		$this->addColumn('gallery_image', 'order', "int(10) NOT NULL DEFAULT '1'");
	}

	public function down()
	{
		echo "m111015_074214_add_gallery_images_columns does not support migration down.\n";
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