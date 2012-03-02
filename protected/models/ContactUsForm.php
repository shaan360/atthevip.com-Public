<?php
/**
 * Login form model class
 */
class ContactUsForm extends CFormModel
{
	/**
	 * @var string - password
	 */
	public $name;
	
	/**
	 * @var string - subject
	 */
	public $subject;
	
	/**
	 * @var string - phone
	 */
	public $phone;
	
	/**
	 * @var string - email
	 */
	public $email;
	
	/**
	 * @var string - message
	 */
	public $message;

	/**
	 * @var string - captcha
	 */
	public $verifyCode;
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('email, name, message, subject', 'required'),
			array('email', 'email'),
			array('message', 'length', 'min' => 3, 'max' => 2000),
			array('verifyCode', 'captcha'),
			array('phone', 'numerical'),
		);
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'email' => Yii::t('site', 'Email'),
			'name' => Yii::t('site', 'Name'),
			'subject' => Yii::t('site', 'Subject'),
			'phone' => Yii::t('site', 'Phone'),
			'message' => Yii::t('site', 'Message'),
			'verifyCode' => Yii::t('site', 'Security Code'),
		);
	}
	
}