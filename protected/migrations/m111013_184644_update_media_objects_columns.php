<?php

class m111013_184644_update_media_objects_columns extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('media_objects', 'container');
		$this->addColumn('media_objects', 'container_id', 'int');
	}

	public function down()
	{
		echo "m111013_184644_update_media_objects_columns does not support migration down.\n";
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