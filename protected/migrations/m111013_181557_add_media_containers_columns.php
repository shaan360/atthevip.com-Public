<?php

class m111013_181557_add_media_containers_columns extends CDbMigration
{
	public function up() {
		$this->addColumn('media_containers', 'container_url', 'string');
	}

	public function down()
	{
		echo "m111013_181557_add_media_containers_columns does not support migration down.\n";
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