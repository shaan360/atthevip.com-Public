<?php

class m111020_193955_add_fb_to_users extends CDbMigration
{
	public function up()
	{
		$this->addColumn('users', 'fb_uid', 'string');
	}

	public function down()
	{
		echo "m111020_193955_add_fb_to_users does not support migration down.\n";
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