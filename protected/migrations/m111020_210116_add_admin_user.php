<?php

class m111020_210116_add_admin_user extends CDbMigration
{
	public function up()
	{
		$data = array(
			'username' => 'admin',
			'seoname' => 'admin',
			'email' => 'vadimg88@gmail.com',
			'password' => Users::model()->hashPassword('vadimg1988', 'vadimg88@gmail.com'),
			'role' => Users::ROLE_ADMIN,
			'joined' => time(),
		);
		$this->insert('users', $data);
	
	}
	
	public function down()
	{
		echo "m111020_210116_add_admin_user does not support migration down.\n";
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