<?php
/**
 * Session
 */
class Sessions extends CActiveRecord
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
		return '{{sessions}}';
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
	 * table data rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return array();
	}
	
	/**
	 * Get logged in admin users
	 * 
	 *
	 */
	public function getLoggedInAdmins() {
		$rows = Sessions::model()->findAll();
		if(!count($rows)) {
			return array();
		}
		$return = array();
		foreach($rows as $row) {
			// Search for admin_info
			if(strpos($row->data, 'admin_info') === false) {
				continue;
			}
			
			$return[] = $row;
		}
		
		return $return;
	}
}