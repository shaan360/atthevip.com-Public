<?php
/**
 * CreatedUserBehavior class file.
 *
 */

class CreatedUserBehavior extends CActiveRecordBehavior {
	/**
	* @var mixed The name of the attribute to store the creation user id.  Set to null to not
	* use a user id for the creation attribute.  Defaults to 'create_user'
	*/
	public $createAttribute = 'create_user';
	/**
	* @var mixed The name of the attribute to store the modification user id.  Set to null to not
	* use a user id for the update attribute.  Defaults to 'update_user'
	*/
	public $updateAttribute = 'update_user';

	/**
	* @var bool Whether to set the update attribute to the creation user id upon creation.
	* Otherwise it will be left alone.  Defaults to false.
	*/
	public $setUpdateOnCreate = false;

	/**
	* @var mixed The expression that will be used for generating the user id.
	*/
	public $userExpression;

	/**
	* Responds to {@link CModel::onBeforeSave} event.
	* Sets the values of the creation or modified attributes as configured
	*
	* @param CModelEvent $event event parameter
	*/
	public function beforeSave($event) {
		if ($this->getOwner()->getIsNewRecord() && ($this->createAttribute !== null)) {
			$this->getOwner()->{$this->createAttribute} = $this->getUserIdByAttribute($this->createAttribute);
		}
		if ((!$this->getOwner()->getIsNewRecord() || $this->setUpdateOnCreate) && ($this->updateAttribute !== null)) {
			$this->getOwner()->{$this->updateAttribute} = $this->getUserIdByAttribute($this->updateAttribute);
		}
	}

	/**
	* Gets the approprate timestamp depending on the column type $attribute is
	*
	* @param string $attribute $attribute
	* @return mixed timestamp (eg unix timestamp or a mysql function)
	*/
	protected function getUserIdByAttribute($attribute) {
		if($this->userExpression !== null) {
			return @eval('return '.$this->userExpression.';');
		}
		
		return 0;
	}
}