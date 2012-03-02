<?php

class m111013_203047_add_object_columns extends CDbMigration
{
	public function up()
	{
		$this->addColumn('media_objects', 'object_link', 'string');
	}

	public function down()
	{
		echo "m111013_203047_add_object_columns does not support migration down.\n";
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