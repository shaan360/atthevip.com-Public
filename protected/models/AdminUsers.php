<?php
/**
 * admin users
 */
class AdminUsers extends CActiveRecord
{		
	/**
	 * @return object
	 */
	public static function model()
	{
		return parent::model(__CLASS__);
	}
	
	/**
	 * @return string Table name
	 */
	public function tableName()
	{
		return '{{admin_users}}';
	}
	
	/**
	 * Relations
	 */
	public function relations()
	{
		return array(
		    'user' => array(self::BELONGS_TO, 'Users', 'userid'),
		);
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels()
	{
		return array();
	}
	
	/**
	 * Before save operations
	 */
	public function beforeSave()
	{
		if( $this->isNewRecord )
		{
			$this->loggedin_time = time();
			$this->userid = Yii::app()->user->id;
			$this->location = Yii::app()->getController()->id;
		} else {
			$this->lastclick_time = time();
			$this->location = Yii::app()->getController()->id;
		}
		
		return parent::beforeSave();
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return array();
	}
}