<?php
/**
 * Users model
 */
class Users extends CActiveRecord
{	
	
	/**
	 * Default member groups
	 */
	const ROLE_ADMIN = 'Admin';
    const ROLE_Staff = 'Staff';
    const ROLE_USER = 'User';
	const ROLE_GUEST = 'guest';
	
	
	/**
	 * @return Users
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
		return '{{users}}';
	}
	
	/**
	 * Relations
	 *
	 * @return array
	 */
	public function relations()
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
		return array(
			array('email', 'email'),
			array('email', 'checkUniqueEmailUpdate'),
			array('username', 'checkUniqueUserUpdate'),
			array('email, username', 'unique', 'on' => 'register' ),
			array('username, email, password', 'required', 'on' => 'register'),
			array('username, password', 'length', 'min' => 3, 'max' => 40),
			array('email', 'length', 'min' => 3, 'max' => 55),
			array('email, role', 'required'),
			array('role', 'checkRole'),
		);
	}
	
	/**
	 * Check to make sure the role is valid
	 */
	public function checkRole()
	{
		$roles = Yii::app()->authManager->getRoles();
		$_temp = array();
		if( count($roles) )
		{
			foreach( $roles as $role )
			{
				$_temp[ $role->name ] = $role->name;
			}
		}
		
		if( !in_array($this->role, $_temp) )
		{
			$this->addError('role', Yii::t('users', 'Please select a valid role.'));
		}
	}
	
	/**
	 * Check that the email is unique
	 */
	public function checkUniqueEmailUpdate()
	{
		if( $this->scenario == 'update' )
		{
			$user = Users::model()->exists('email=:email AND id!=:id', array(':email'=>$this->email, ':id'=>$this->id));
			if( $user )
			{
				$this->addError('email', Yii::t('users', 'Sorry, That email is already in use by another member.'));
			}
		}
	}
	/**
	 * Check that the username is unique
	 */
	public function checkUniqueUserUpdate()
	{
		if( $this->scenario == 'update' )
		{
			$user = Users::model()->exists('username=:username AND id!=:id', array(':username'=>$this->username, ':id'=>$this->id));
			if( $user )
			{
				$this->addError('username', Yii::t('users', 'Sorry, That username is already in use by another member.'));
			}
		}
	}
	
	/**
	 * Simple yet efficient way for password hashing
	 */
	public function hashPassword( $password, $salt )
	{
		return sha1( md5($salt) . $password );
	}
	
	/**
	 * Generate a random readable password
	 */
	public function generatePassword($minLength=5, $maxLength=10)
	{
		$length=rand($minLength,$maxLength);

		$letters='bcdfghjklmnpqrstvwxyz';
		$vowels='aeiou';
		$code='';
		for($i=0;$i<$length;++$i)
		{
			if($i%2 && rand(0,10)>2 || !($i%2) && rand(0,10)>9)
				$code.=$vowels[rand(0,4)];
			else
				$code.=$letters[rand(0,20)];
		}

		return $code;
	}
	
	/**
	 * Save date and password before saving
	 */
	public function beforeSave()
	{
		if( $this->isNewRecord )
		{
			$this->joined = time();
			$this->ipaddress = Yii::app()->request->getUserHostAddress();
		}
		
		if( $this->scenario == 'register' || $this->scenario == 'change' )
		{
			$this->password = $this->hashPassword( $this->password, $this->email );
		}
		
		if( ( $this->scenario == 'update' && $this->password ) )
		{
			$this->password = $this->hashPassword( $this->password, $this->email );
		}
		
		// Make an seo name based on the username
		$this->seoname = Yii::app()->func->makeAlias( $this->username );
		
		// Save data array as serialized string
		if( is_array( $this->data ) && count( $this->data ) )
		{
			$this->data = serialize( $this->data );
		}
		
		return parent::beforeSave();
	}
	
	/**
	 * Get link to user
	 */
	public function getLink( $name, $id, $alias, $htmlOptions=array() )
	{
		return CHtml::link( CHtml::encode($name), array('/user/' . $id . '-' . $alias, 'lang'=>false), $htmlOptions );
	}
	
	/**
	 * Get link to user - faster
	 */
	public function getModelLink( $htmlOptions=array() )
	{
		return $this->getLink( $this->username, $this->id, $this->seoname, $htmlOptions );
	}
	
	/**
	 * Attribute values
	 *
	 * @return array
	 */
	public function attributeLabels()
	{
		return array(
			'username' => Yii::t('users', 'Username'),
			'email' => Yii::t('users', 'Email'),
			'password' => Yii::t('users', 'Password'),
			'password2' => Yii::t('users', 'Password Confirmation'),
			'joined' => Yii::t('users', 'Joined'),
		);
	}
	
	
	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	
	/**
	 * @return either string or hash
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	/**
	 * @return string
	 */
	public function getJoined()
	{
		return Yii::app()->dateFormatter->formatDateTime( $this->joined, 'short', '' );
	}
	
	/**
	 * @return array
	 */
	public function getMemberData()
	{
		return unserialize( $this->data );
	}
	
	/**
	 * Get member profile link
	 */
	public function getProfileLink()
	{
		return CHtml::link( $this->username, array('/user/' . $this->id . '-' . $this->seoname, 'lang'=>false ) );
	}
	
}
