<?php
/**
 * Login form model class
 */
class AdminLogin extends CFormModel
{
	/**
	 * @var string - password
	 */
	public $password;
	
	/**
	 * @var string - email
	 */
	public $email;
	
	/**
	 * @var boolean - remember me
	 */
	public $rememberme = false;
	
	public $identity;
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('email, password', 'required'),
			array('email', 'email'),
			array('password', 'length', 'min' => 3, 'max' => 32),
			array('email', 'length', 'min' => 3, 'max' => 55),
			array('rememberme', 'boolean'),
			array('password', 'authenticate'),
		);
	}
	
	/**
	 * @return null on success error on failure
	 */
	public function authenticate()
	{
		$this->identity = new InternalIdentity($this->email, $this->password);
		if($this->identity->authenticate())
		{
			// Member authenticated
			return true;
		}
		else
		{
			$this->addError('password', $this->identity->errorMessage);
		}
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'email' => Yii::t('users', 'Email'),
			'password' => Yii::t('users', 'Password'),
		);
	}
	
}