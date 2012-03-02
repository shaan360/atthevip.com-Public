<?php
/**
 * users controller Home page
 */
class UsersController extends AdminBaseController {
	/**
	 * Number or records to display on a single page
	 */
	const PAGE_SIZE = 50;
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_users_view');
		
		$this->breadcrumbs[ Yii::t('adminglobal', 'Users') ] = array('users/index');
		$this->pageTitle[] = Yii::t('adminglobal', 'Users');
	}
	/**
	 * Index action
	 */
    public function actionIndex() 
	{
		// Did we submit the form and selected items?
		if( isset($_POST['bulkoperations']) && $_POST['bulkoperations'] != '' )
		{
			// Check Access
			checkAccessThrowException('op_users_bulk_users');
			
			// Did we choose any values?
			if( isset($_POST['user']) && count($_POST['user']) )
			{
				// What operation we would like to do?
				switch( $_POST['bulkoperations'] )
				{
					case 'bulkdelete':
					
					// Check Access
					checkAccessThrowException('op_users_delete_users');
					
					// Load users and delete them
					$members_deleted = Users::model()->deleteByPk(array_keys($_POST['user']));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('users', '{count} users deleted.', array('{count}'=>$members_deleted)));
					break;
					
					default:
					// Nothing
					break;
				}
			}
		}
		
		
		// Load members and display
		$criteria = new CDbCriteria;

		$count = Users::model()->count();
		
		$members = Users::model()->findAll($criteria);
	
        $this->render('index', array( 'count' => $count, 'members' => $members ) );
    }

	/**
	 * Add user action
	 */
	public function actionadduser()
	{
		// Check Access
		checkAccessThrowException('op_users_add_users');
		
		$model = new Users;
		
		if( isset( $_POST['Users'] ) )
		{
			$model->attributes = $_POST['Users'];
			$model->scenario = 'register';

			if( $model->save() )
			{
				// Loop through the roles and assign them
				$types = array( 'roles', 'tasks', 'operations' );
				$lastID = Yii::app()->db->lastInsertID;
				foreach($types as $type)
				{
					if( isset($_POST[ $type ]) && count( $_POST[ $type ] ) )
					{
						foreach( $_POST[ $type ] as $others )
						{						
							// assign if not assigned yet
							if( !Yii::app()->authManager->isAssigned( $others, $lastID ) )
							{
								$authItem = Yii::app()->authManager->getAuthItem( $others );
								Yii::app()->authManager->assign( $others, $lastID, $authItem->bizrule, $authItem->data );
							}
						}
					}
				}
				
				Yii::app()->user->setFlash('success', Yii::t('users', 'User Added.'));
				$this->redirect(array('users/viewuser', 'id' => $model->id ));
			}
		}
		
		$temp = Yii::app()->authManager->getAuthItems();
		$items = array( CAuthItem::TYPE_ROLE => array(), CAuthItem::TYPE_TASK => array(), CAuthItem::TYPE_OPERATION => array() );
		if( count($temp) )
		{
			foreach( $temp as $item )
			{
				$items[ $item->type ][ $item->name ] = $item->name;
			}
		}
		
		$items_selected = array();
		$items_selected['roles'] = isset($_POST['roles']) ? $_POST['roles'] : '';
		$items_selected['tasks'] = isset($_POST['tasks']) ? $_POST['tasks'] : '';
		$items_selected['operations'] = isset($_POST['operations']) ? $_POST['operations'] : '';
		
		$this->breadcrumbs[ Yii::t('users', 'Adding User') ] = '';
		$this->pageTitle[] = Yii::t('users', 'Adding User');
		
		// Display form
		$this->render('user_form', array( 'items_selected' => $items_selected, 'items' => $items, 'model' => $model, 'label' => Yii::t('users', 'Adding User') ));
	}
	/**
	 * Update user action
	 */
	public function actionedituser()
	{
		
		// Check Access
		checkAccessThrowException('op_users_edit_users');
		
		if( isset($_GET['id']) && ($model = Users::model()->findByPk($_GET['id']) ) )
		{
			if( isset( $_POST['Users'] ) )
			{
				$model->attributes = $_POST['Users'];
				$model->scenario = 'update';
				if( $model->save() )
				{
					
					// Loop through the roles and assign them
					$types = array( 'roles', 'tasks', 'operations' );
					$lastID = $model->id;
					$allitems = Yii::app()->authManager->getAuthItems(null, $lastID);
					
					if( count($allitems) )
					{
						foreach( $allitems as $allitem )
						{
							Yii::app()->authManager->revoke( $allitem->name, $lastID );
						}
					}
					
					foreach($types as $type)
					{
						if( isset($_POST[ $type ]) && count( $_POST[ $type ] ) )
						{
							foreach( $_POST[ $type ] as $others )
							{						
								// assign if not assigned yet
								if( !Yii::app()->authManager->isAssigned( $others, $lastID ) )
								{
									$authItem = Yii::app()->authManager->getAuthItem( $others );
									Yii::app()->authManager->assign( $others, $lastID, $authItem->bizrule, $authItem->data );
								}
							}
						}
					}
					
					Yii::app()->user->setFlash('success', Yii::t('users', 'User Updated.'));
					$this->redirect(array('users/viewuser', 'id'=>$model->id));
				}
			}
			
			$temp = Yii::app()->authManager->getAuthItems();
			$items = array( CAuthItem::TYPE_ROLE => array(), CAuthItem::TYPE_TASK => array(), CAuthItem::TYPE_OPERATION => array() );
			if( count($temp) )
			{
				foreach( $temp as $item )
				{
					$items[ $item->type ][ $item->name ] = $item->name;
				}
			}
			
			// Selected
			$temp_selected = Yii::app()->authManager->getAuthItems(null, $model->id);
			$items_selected = array();
			if( count($temp) )
			{
				foreach( $temp_selected as $item_selected )
				{
					$items_selected[ $item_selected->type ][ $item_selected->name ] = $item_selected->name;
				}
			}
			
			$model->password = '';
			
			$this->breadcrumbs[ Yii::t('users', 'Editing User') ] = '';
			$this->pageTitle[] = Yii::t('users', 'Editing User');

			// Display form
			$this->render('user_form', array( 'items_selected' => $items_selected, 'items' => $items, 'model' => $model, 'label' => Yii::t('users', 'Editing User') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('adminerror', 'Could not find that ID.'));
			$this->redirect(array('users/index'));
		}
	}
	/**
	 * Delete user action
	 */
	public function actiondeleteuser()
	{
		
		// Check Access
		checkAccessThrowException('op_users_delete_users');
		
		if( isset($_GET['id']) && ( $model = Users::model()->findByPk($_GET['id']) ) )
		{			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('users', 'User Deleted.'));
			$this->redirect(array('index'));
		}
		else
		{
			$this->redirect(array('users/index'));
		}
	}
	/**
	 * View user action
	 */
	public function actionviewuser()
	{
		if( isset($_GET['id']) && ($model = Users::model()->findByPk($_GET['id']) ) )
		{			
			$this->breadcrumbs[ Yii::t('users', 'Viewing User') ] = '';
			$this->pageTitle[] = Yii::t('users', 'Viewing User');

			// Display
			$this->render('user_view', array( 'model' => $model, 'label' => Yii::t('users', 'Viewing User') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('adminerror', 'Could not find that ID.'));
			$this->redirect(array('users/index'));
		}
	}
}