<?php

class m111020_213906_admin_login_users extends CDbMigration
{
	public function up()
	{
		$this->createTable('admin_users', array(
			'id' => 'pk',
			'userid' => 'int',
			'loggedin_time' => 'int',
			'lastclick_time' => 'int',
			'location' => 'string',
		));
	}

	public function down()
	{
		echo "m111020_213906_admin_login_users does not support migration down.\n";
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