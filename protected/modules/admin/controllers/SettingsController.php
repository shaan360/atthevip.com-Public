<?php
/**
 * Settings controller Home page
 */
class SettingsController extends AdminBaseController {
	/**
	 * init
	 */
	public function init() {
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_settings_view');
		
		$this->breadcrumbs[ Yii::t('admin', 'Settings') ] = array('settings/index');
		$this->pageTitle[] = Yii::t('admin', 'Settings');	
	}
	
	/**
	 * Index action
	 */
    public function actionIndex() {
		// Grab settings
		$settings = SettingsCats::model()->with(array('count'))->findAll();
        $this->render('index', array( 'settings' => $settings ));
    }

	/**
	 * Add setting group action
	 */
	public function actionaddgroup()
	{
		// Check Access
		checkAccessThrowException('op_settings_add_settings_groups');
		
		$model = new SettingsCats;
		
		if( isset( $_POST['SettingsCats'] ) )
		{
			$model->attributes = $_POST['SettingsCats'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting group added.'));
				$this->redirect(array('settings/index'));
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding setting group') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding setting group');
		
		// Display form
		$this->render('group_form', array( 'model' => $model, 'label' => Yii::t('adminsettings', 'Adding setting group') ));
	}
	
	/**
	 * Edit setting group action
	 */
	public function actioneditgroup()
	{
		// Check Access
		checkAccessThrowException('op_settings_edit_settings_groups');
		
		if( isset($_GET['id']) && ($model = SettingsCats::model()->findByPk($_GET['id']) ) )
		{
			if( isset( $_POST['SettingsCats'] ) )
			{
				$model->attributes = $_POST['SettingsCats'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting group updated.'));
					$this->redirect(array('settings/index'));
				}
			}
			
			$this->breadcrumbs[ Yii::t('admin', 'Editing setting group') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing setting group');

			// Display form
			$this->render('group_form', array( 'model' => $model, 'label' => Yii::t('adminsettings', 'Editing setting group') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('adminerror', 'Could not find that ID.'));
			$this->redirect(array('settings/index'));
		}
	}
	
	/**
	 * Delete setting group action
	 */
	public function actiondeletegroup()
	{
		// Check Access
		checkAccessThrowException('op_settings_delete_settings_groups');
		
		if( isset($_GET['id']) && ( $model = SettingsCats::model()->with(array('settings'))->findByPk($_GET['id']) ) )
		{
			// Do we have any settings in it?
			if( count($model->settings) )
			{
				Yii::app()->user->setFlash('error', Yii::t('adminerror', "Can't delete that setting group as it contains active settings."));
				$this->redirect(array('settings/index'));
			}
			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting group deleted.'));
			$this->redirect(array('settings/index'));
		}
		else
		{
			$this->redirect(array('settings/index'));
		}
	}
	
	/**
	 * View group settings action
	 */
	public function actionviewgroup()
	{
		// Check Access
		checkAccessThrowException('op_settings_view_settings');
		
		if( isset($_GET['id']) && ( $category = SettingsCats::model()->findByPk($_GET['id']) ) )
		{
			// Submit?
			if( isset( $_POST['submit'] ) )
			{	
				// Check Access
				checkAccessThrowException('op_settings_update_settings');
				
				if( count( $_POST ) )
				{
					foreach( $_POST as $key => $value )
					{
						if( !preg_match('/setting_\d+/', $key) )
						{
							continue;
						}
						
						// Get the id
						$settingID = str_replace('setting_', '', $key);
						$settingValue = ( is_array( $value ) && count( $value ) ) ? implode(',', $value) : $value;
						
						// Update setting
						Settings::model()->updateByPk($settingID, array( 'value' => $settingValue ));
					}
				}
				
				// Clear cache
				Yii::app()->settings->clearCache();
				
				// Updated redirect
				Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Settings Updated.'));
				$this->redirect(array('settings/viewgroup', 'id'=>$_GET['id']));
			}
			
			// Grab all settings by this group
			$settings = Settings::model()->findAll('category=:category', array( ':category' => $_GET['id'] ));
			
			// Set title and breadcrumbs
			$this->breadcrumbs[ Yii::t('admin', $category->title) ] = '';
			$this->pageTitle[] = Yii::t('admin', $category->title );
			
			// Set info
			Yii::app()->user->setFlash('information', Yii::t('adminsettings', 'Hover over the setting title to see a description if one exists.'));
			
			// Render
			$this->render('group_view', array( 'settings' => $settings ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('adminerror', 'Could not find that ID.'));
			$this->redirect(array('settings/index'));
		}
	}
	
	/**
	 * Add setting action
	 */
	public function actionaddsetting()
	{
		// Check Access
		checkAccessThrowException('op_settings_add_settings');
		
		$model = new Settings;

		if( isset($_GET['cid']) && ( $category = SettingsCats::model()->findByPk($_GET['cid']) ) )
		{
			$model->category = $category->id;
			
			$this->breadcrumbs[ Yii::t('admin', $category->title) ] = array('settings/index', 'id' => $category->id);
			$this->pageTitle[] = Yii::t('admin', $category->title);
		}
		
		if( isset( $_POST['Settings'] ) )
		{
			$model->attributes = $_POST['Settings'];
			if( $model->save() )
			{
				// Clear cache
				Yii::app()->settings->clearCache();
				
				Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting added.'));
				$this->redirect(array('settings/viewgroup', 'id' => $model->category));
			}
		}
		
		$this->breadcrumbs[ Yii::t('admin', 'Adding Setting') ] = '';
		$this->pageTitle[] = Yii::t('admin', 'Adding Setting');
		
		// Display form
		$this->render('setting_form', array( 'model' => $model, 'label' => Yii::t('adminsettings', 'Adding Setting') ));
	}
	
	/**
	 * Edit setting action
	 */
	public function actioneditsetting()
	{
		// Check Access
		checkAccessThrowException('op_settings_edit_settings');
		
		if( isset($_GET['id']) && ( $model = Settings::model()->findByPk($_GET['id']) ) )
		{
			if( ( $category = SettingsCats::model()->findByPk($model->category) ) )
			{
				$model->category = $category->id;
			
				$this->breadcrumbs[ Yii::t('admin', $category->title) ] = array('settings/index', 'id' => $category->id);
				$this->pageTitle[] = Yii::t('admin', $category->title);
			}
		
			if( isset( $_POST['Settings'] ) )
			{
				$model->attributes = $_POST['Settings'];
				if( $model->save() )
				{
					// Clear cache
					Yii::app()->settings->clearCache();
					
					Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting edited.'));
					$this->redirect(array('settings/viewgroup', 'id' => $model->category));
				}
			}
		
			$this->breadcrumbs[ Yii::t('admin', 'Editing Setting') ] = '';
			$this->pageTitle[] = Yii::t('admin', 'Editing Setting');
		
			// Display form
			$this->render('setting_form', array( 'model' => $model, 'label' => Yii::t('adminsettings', 'Editing Setting') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('adminerror', 'Could not find that ID.'));
			$this->redirect(array('settings/index'));
		}
	}
	
	/**
	 * Delete setting action
	 */
	public function actiondeletesetting()
	{
		// Check Access
		checkAccessThrowException('op_settings_delete_settings');
		
		if( isset($_GET['id']) )
		{
			$model = Settings::model()->findByPk($_GET['id']);
			
			Settings::model()->deleteByPk($_GET['id']);
			
			// Clear cache
			Yii::app()->settings->clearCache();
			
			Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting deleted.'));
			if($model) {
				$this->redirect(array('settings/viewgroup', 'id' => $model->category));
			}
			$this->redirect(array('settings/index'));
		}
		else
		{
			$this->redirect(array('settings/index'));
		}
	}
	/**
	 * Revert setting action
	 */
	public function actionrevertsetting()
	{
		// Check Access
		checkAccessThrowException('op_settings_revert_settings');
		
		if( isset($_GET['id']) )
		{
			$model = Settings::model()->findByPk($_GET['id']);
			
			Settings::model()->updateByPk($_GET['id'], array('value'=>$model->default_value));
			
			// Clear cache
			Yii::app()->settings->clearCache();
			
			Yii::app()->user->setFlash('success', Yii::t('adminsettings', 'Setting Reverted.'));
			$this->redirect(array('settings/viewgroup', 'id'=>$model->category));
		}
		else
		{
			$this->redirect(array('settings/index'));
		}
	}
	
	/**
	 * Parse each setting
	 */
	public function parseSetting( $setting )
	{
		$name = 'setting_' . $setting->id;
		$value = $setting->value ? $setting->value : $setting->default_value;
		
		switch( $setting->type )
		{
			case 'textarea':
			echo CHtml::textArea( $name, $value, array( 'rows' => 5, 'class' => 'textbox' ) );
			break;
			
			case 'dropdown':
			echo CHtml::dropDownList( $name, $value, $this->convertExtraToArray( $setting->extra ), array( 'class' => 'chosen' ) );
			break;
			
			case 'multi':
			echo CHtml::listBox( $name, $value ? explode(',', $value) : '', $this->convertExtraToArray( $setting->extra ), array( 'multiple' => 'multiple', 'class' => 'chosen' ) );
			break;
			
			case 'checkbox':
			echo CHtml::checkbox( $name, $setting->value != '' ? $setting->value : $setting->default_value, array( 'class' => '' ) );
			break;
			
			case 'yesno':
			echo CHtml::dropDownList( $name, $value, array( '0' => Yii::t('global', 'No'), '1' => Yii::t('global', 'Yes') ), array( 'class' => 'chosen' ) );
			break;
			
			case 'editor':
			$this->createWidget('application.widgets.ckeditor.CKEditor', array( 'name' => $name, 'value' => $value, 'editorTemplate' => 'basic' ))->run();
			break;
			
			case 'text':
			default:
			echo CHtml::textField( $name, $value, array( 'class' => 'textbox' ) );
			break;
		}
	}
	
	/**
	 * Convert extra data to an array of key=>value pairs
	 */
	protected function convertExtraToArray( $string ) {
		if( !$string )
		{
			return array();
		}
		
		$_temp = array();
		
		if( $string == '#show_roles#' )
		{
			$roles = Yii::app()->authManager->getRoles();
			if( count($roles) )
			{
				foreach( $roles as $role )
				{
					$_temp[ $role->name ] = $role->name;
				}
			}
		}
		else if( $string == '#show_blogcats#' )
		{
			// Parent list
			$parentlist = BlogCats::model()->getRootCats();
			if( count( $parentlist ) )
			{
				foreach($parentlist as $row)
				{
					$_temp[ $row->id ] = $row->title;
				}
			}
		}
		else
		{
			$exploded = explode("\n", $string);

			if( count($exploded) )
			{
				foreach( $exploded as $explode )
				{
					list($key, $value) = explode('=', $explode);
					$_temp[$key] = $value;
				}
			}
		}	
		
		return $_temp;
	}
	
}