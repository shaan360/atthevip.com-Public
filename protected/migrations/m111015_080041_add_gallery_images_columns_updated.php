<?php

class m111015_080041_add_gallery_images_columns_updated extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('gallery_image', 'order');
		$this->addColumn('gallery_image', 'order', "float(10) NOT NULL DEFAULT '1'");
	}

	public function down()
	{
		echo "m111015_080041_add_gallery_images_columns_updated does not support migration down.\n";
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