<?php

class m111014_222011_add_gallery_images_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('gallery_image', array(
			'id' => 'pk',
			'gallery_id' => 'int',
			'small_object_id' => 'int',
			'medium_object_id' => 'int',
			'large_object_id' => 'int',
			'created_date' => 'int',
			'created_user' => 'int',
			'is_public' => 'tinyint(1) NOT NULL default "1"',
		));
	}

	public function down()
	{
		echo "m111014_222011_add_gallery_images_table does not support migration down.\n";
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