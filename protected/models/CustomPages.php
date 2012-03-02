<?php
/**
 * custom pages model
 */
class CustomPages extends CActiveRecord
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
		return '{{custompages}}';
	}
	
	/**
	 * Relations
	 */
	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'Users', 'authorid'),
			'lastauthor' => array(self::BELONGS_TO, 'Users', 'last_edited_author'),
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
			'title' => Yii::t('custompages', 'Title'),
			'alias' => Yii::t('custompages', 'Alias'),
			'content' => Yii::t('custompages', 'Content'),
			'tags' => Yii::t('custompages', 'Tags'),
			'language' => Yii::t('custompages', 'Language'),
			'metadesc' => Yii::t('custompages', 'Meta Description'),
			'metakeys' => Yii::t('custompages', 'Meta Keywords'),
			'visible' => Yii::t('custompages', 'Visibility'),
			'status' => Yii::t('custompages', 'Status'),
		);
	}
	
	/**
	 * Before save operations
	 */
	public function beforeSave()
	{
		if( $this->isNewRecord )
		{
			$this->dateposted = time();
			$this->authorid = Yii::app()->user->id;
		}
		else
		{
			$this->last_edited_date = time();
			$this->last_edited_author = Yii::app()->user->id;
		}
		
		// Fix the language, tags and visibility
		$this->visible = ( is_array( $this->visible ) && count( $this->visible ) ) ? implode(',', $this->visible) : $this->visible;

		// Alias
		$this->alias = str_replace(' ', '-', $this->alias);
		
		return parent::beforeSave();
	}
	
	/**
	 * after save method
	 */
	public function afterSave()
	{
		Yii::app()->urlManager->clearCache();
		
		return parent::afterSave();
	}
	
	/**
	 * table data rules
	 *
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('title, alias, content', 'required' ),
			array('alias', 'CheckUniqueAlias'),
			//array('language', 'required'),
			array('title, alias', 'length', 'min' => 3, 'max' => 55 ),
			array('alias', 'match', 'allowEmpty'=>false, 'pattern'=>'/^[A-Za-z0-9_-]+$/'),
			array('metadesc, metakeys, visible, status, tags, language', 'safe' ),
		);
	}
	
	/**
	 * Check alias and language combination
	 */
	public function CheckUniqueAlias()
	{
		if( $this->isNewRecord )
		{
			// Check if we already have an alias with those parameters
			if( self::model()->exists('alias=:alias', array(':alias' => $this->alias ) ) )
			{
				$this->addError('alias', Yii::t('custompages', 'There is already a page with that alias.'));
			}
		}
		else
		{
			// Check if we already have an alias with those parameters
			if( self::model()->exists('alias=:alias AND id!=:id', array( ':id' => $this->id, ':alias' => $this->alias) ) )
			{
				$this->addError('alias', Yii::t('custompages', 'There is already a page with that alias.'));
			}
		}
	}
}