<?php

class m111020_194235_add_view_counts extends CDbMigration
{
	public function up()
	{
		$this->addColumn('gallery', 'views', 'int');
		$this->addColumn('event', 'views', 'int');
	}

	public function down()
	{
		echo "m111020_194235_add_view_counts does not support migration down.\n";
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