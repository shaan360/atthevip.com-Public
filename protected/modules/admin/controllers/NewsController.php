<?php
/**
 * News controller Home page
 */
class NewsController extends AdminBaseController {
	/**
	 * Number of items per page
	 */
	const PAGE_SIZE = 500;
	/**
	 * init
	 */
	public function init()
	{
		parent::init();
		
		// Check Access
		checkAccessThrowException('op_news_view');
		
		$this->breadcrumbs[ Yii::t('news', 'News') ] = array('news/index');
		$this->pageTitle[] = Yii::t('news', 'News'); 
	}
	/**
	 * Index action
	 */
    public function actionIndex() {
	
		// Did we hit the submit button?
		if( isset( $_POST['submit'] ) && $_POST['submit'] )
		{
			
			// Check Access
			checkAccessThrowException('op_news_managecats');
			
			if( isset($_POST['pos']) && count($_POST['pos']) )
			{
				foreach($_POST['pos'] as $id => $pos)
				{
					NewsCats::model()->updateByPk($id, array('position'=>$pos));
				}
				
				// Mark
				Yii::app()->user->setFlash('success', Yii::t('news', 'Categories Reordered.'));
			}
		}
		
		$this->breadcrumbs[ Yii::t('news', 'Categories') ] = '';
		$this->pageTitle[] = Yii::t('news', 'Categories');
		
        $this->render('index', array('rows' => NewsCats::model()->getRootCats()));
    }

	/**
	 * Mark category as readonly or not
	 */
	public function actioncatreadonly()
	{
		// Check Access
		checkAccessThrowException('op_news_managecats');
		
		if( isset($_GET['id']) && ( $model = NewsCats::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->readonly ? 0 : 1;
			$model->readonly = $update;
			$model->save();
			
			Yii::app()->user->setFlash('success', Yii::t('news', 'Category status Updated.'));
			$this->redirect(array('index'));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('news', 'Category was not found.'));
			$this->redirect(array('index'));
		}
	}
	
	/**
	 * Add category action
	 */
	public function actionaddcategory()
	{
		// Check Access
		checkAccessThrowException('op_news_addcats');
		
		$model = new NewsCats;
		
		if( isset($_POST['NewsCats']) )
		{
			$model->attributes = $_POST['NewsCats'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('news', 'Category Added.'));
				$this->redirect(array('index'));
			}
		}
		
		// Adding sub?
		if( Yii::app()->request->getParam('parentid') )
		{
			$model->parentid = Yii::app()->request->getParam('parentid');
		}
		
		$roles = AuthItem::model()->findAll(array('order'=>'type DESC, name ASC'));
		$_roles = array();
		if( count($roles) )
		{
			foreach($roles as $role)
			{
				$_roles[ AuthItem::model()->types[ $role->type ] ][ $role->name ] = $role->name;
			}
		}
		
		// Parent list
		$parents = array();
		$parentlist = NewsCats::model()->getRootCats();
		if( count( $parentlist ) )
		{
			foreach($parentlist as $row)
			{
				$parents[ $row->id ] = $row->title;
			}
		}
	
		$this->breadcrumbs[ Yii::t('news', 'Adding Category') ] = '';
		$this->pageTitle[] = Yii::t('news', 'Adding Category');
		
		// Render
		$this->render('category_form', array('model'=>$model, 'parents' => $parents, 'roles' => $_roles, 'label'=>Yii::t('news', 'Adding Category') ));
	}
	
	/**
	 * Edit category action
	 */
	public function actioneditcategory()
	{
		// Check Access
		checkAccessThrowException('op_news_editcats');
		
		if( isset($_GET['id']) && ( $model = NewsCats::model()->findByPk( $_GET['id'] ) ) )
		{
			if( isset($_POST['NewsCats']) )
			{
				$model->attributes = $_POST['NewsCats'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('news', 'Category Updated.'));
					$this->redirect(array('index'));
				}
			}
		
			$roles = AuthItem::model()->findAll(array('order'=>'type DESC, name ASC'));
			$_roles = array();
			if( count($roles) )
			{
				foreach($roles as $role)
				{
					$_roles[ AuthItem::model()->types[ $role->type ] ][ $role->name ] = $role->name;
				}
			}
		
			// Parent list
			$parents = array();
			$parentlist = NewsCats::model()->getRootCats();
			if( count( $parentlist ) )
			{
				foreach($parentlist as $row)
				{
					$parents[ $row->id ] = $row->title;
				}
			}
			
			$model->viewperms = $model->viewperms ? explode(',', $model->viewperms) : $model->viewperms;
			$model->addpostsperms = $model->addpostsperms ? explode(',', $model->addpostsperms) : $model->addpostsperms;
			$model->addcommentsperms = $model->addcommentsperms ? explode(',', $model->addcommentsperms) : $model->addcommentsperms;
			$model->addfilesperms = $model->addfilesperms ? explode(',', $model->addfilesperms) : $model->addfilesperms;
			$model->autoaddperms = $model->autoaddperms ? explode(',', $model->autoaddperms) : $model->autoaddperms;
		
			$this->breadcrumbs[ Yii::t('news', 'Editing Category') ] = '';
			$this->pageTitle[] = Yii::t('news', 'Editing Category');
		
			// Render
			$this->render('category_form', array('model'=>$model, 'parents' => $parents, 'roles' => $_roles, 'label'=>Yii::t('news', 'Editing Category') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('news', 'Category was not found.'));
			$this->redirect(array('index'));
		}
	}
	
	/**
	 * Delete category
	 */
	public function actiondeletecategory()
	{
		// Check Access
		checkAccessThrowException('op_news_deletecats');
		
		if( isset($_GET['id']) && ( $model = NewsCats::model()->findByPk( $_GET['id'] ) ) )
		{
			// If we don't have any sub cats or news then just go ahead and delete
			$posts = $model->posts;
			$childs = $model->childs;
			
			if( ( !count($posts) && !count($childs) ) )
			{
				$model->delete();
				Yii::app()->user->setFlash('success', Yii::t('news', 'Category Deleted.'));
				$this->redirect(array('index'));
			}
			
			// Remove the category we are deleting and the ones beneth it
			$removecats = array();
			$removecats[] = $model->id;
			$subcats = NewsCats::model()->getRecursiveCats($model);
			if( count($subcats) )
			{
				foreach($subcats as $data)
				{
					$removecats[] = $data->id;
				}
			}
			
			// Parent list
			$parents = array();
			$parentlist = NewsCats::model()->getRootCats();
			if( count( $parentlist ) )
			{
				foreach($parentlist as $row)
				{
					if( in_array($row->id, $removecats) )
					{
						continue;
					}
					$parents[ $row->id ] = $row->title;
				}
			}
			
			// Did we submit the form?
			if( isset( $_POST['submit'] ) && $_POST['submit'] )
			{
				$movecatid = $_POST['catsmoveto'];
				$movetutid = $_POST['catsmovetuts'];
				
				// Category is invalid
				if( ( !in_array($movecatid, array_keys($parents)) || !in_array($movetutid, array_keys($parents)) ) )
				{
					Yii::app()->user->setFlash('error', Yii::t('news', 'You must specify a valid category to move the items.'));
				}
				else
				{
					// Update cats
					NewsCats::model()->updateAll( array('parentid'=>$movecatid), 'parentid=:parent', array(':parent'=>$model->id) );
					
					// Update post
					News::model()->updateAll( array('catid'=>$movetutid), 'catid=:cat', array(':cat'=>$model->id) );
					
					// Delete cat
					$model->delete();
					
					Yii::app()->user->setFlash('success', Yii::t('news', 'Category Deleted.'));
					$this->redirect(array('index'));
				}
				
			}
			
			$this->breadcrumbs[ Yii::t('news', 'Delete Category') ] = '';
			$this->pageTitle[] = Yii::t('news', 'Delete Category');
			
			// Show render
			$this->render('delete_form', array('model'=>$model, 'childs' => $childs, 'parents' => $parents, 'label'=>Yii::t('news', 'Delete Category')));
		}
		else
		{
			//Yii::app()->user->setFlash('error', Yii::t('news', 'Category was not found.'));
			$this->redirect(array('index'));
		}
	}
	
	/**
	 * view category action
	 */
    public function actionviewcategory() 
	{
		// Check Access
		checkAccessThrowException('op_news_manage');
		
		if( isset($_GET['id']) && ( $model = NewsCats::model()->findByPk( $_GET['id'] ) ) )
		{
			// Did we submit the form and selected items?
			if( isset($_POST['bulkoperations']) && $_POST['bulkoperations'] != '' )
			{			
				// Check Access
				checkAccessThrowException('op_news_manage');
				
				// Did we choose any values?
				if( isset($_POST['record']) && count($_POST['record']) )
				{
					// What operation we would like to do?
					switch( $_POST['bulkoperations'] )
					{					
						case 'bulkapprove':
						// Load records
						$records = News::model()->updateByPk(array_keys($_POST['record']), array('status'=>1));
						// Done
						Yii::app()->user->setFlash('success', Yii::t('news', '{count} News Approved.', array('{count}'=>$records)));
						break;
					
						case 'bulkunapprove':
						// Load records
						$records = News::model()->updateByPk(array_keys($_POST['record']), array('status'=>0));
						// Done
						Yii::app()->user->setFlash('success', Yii::t('news', '{count} News Un-Approved.', array('{count}'=>$records)));
						break;
					
						default:
						// Nothing
						break;
					}
				}
			}

			// Load users and display
			$criteria = new CDbCriteria;
			$criteria->condition = 'catid=:cat';
			$criteria->params = array( ':cat' => $model->id );

			$count = News::model()->count($criteria);
			$pages = new CPagination($count);
			$pages->pageSize = self::PAGE_SIZE;
		
			$pages->applyLimit($criteria);
		
			$sort = new CSort('News');
			$sort->defaultOrder = 'postdate DESC';
			$sort->applyOrder($criteria);

			$sort->attributes = array(
			        'title'=>'title',
			        'alias'=>'alias',
					'author'=>'authorid',
			        'postdate'=>'postdate',
			        'language'=>'language',
					'status'=>'status',
			);
		
			$rows = News::model()->with(array('author','lastauthor'))->findAll($criteria);
			
			// Add breadcrumbs and title
			$this->breadcrumbs[ Yii::t('news', 'Viewing Category') ] = '';
			$this->pageTitle[] = Yii::t('news', 'Viewing Category');
	
        	$this->render('posts', array( 'model' => $model, 'count' => $count, 'rows' => $rows, 'pages' => $pages, 'sort' => $sort ) );
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('news', 'Category was not found.'));
			$this->redirect(array('index'));
		}	
    }

	/**
	 * Add post action
	 */
	public function actionaddpost()
	{
		// Check Access
		checkAccessThrowException('op_news_addposts');
		
		$model = new News;
		
		if( isset($_POST['News']) )
		{
			$model->attributes = $_POST['News'];
			if( $model->save() )
			{
				Yii::app()->user->setFlash('success', Yii::t('news', 'Post Added.'));
				$this->redirect(array('viewcategory', 'id'=>$model->catid));
			}
		}
		
		// Adding by cat?
		if( Yii::app()->request->getParam('catid') )
		{
			$model->catid = Yii::app()->request->getParam('catid');
		}
		
		// cat list
		$parents = array();
		$parentlist = NewsCats::model()->getRootCats();
		if( count( $parentlist ) )
		{
			foreach($parentlist as $row)
			{
				$parents[ $row->id ] = $row->title;
			}
		}
	
		$this->breadcrumbs[ Yii::t('news', 'Adding Post') ] = '';
		$this->pageTitle[] = Yii::t('news', 'Adding Post');
		
		// Render
		$this->render('post_form', array('model'=>$model, 'parents' => $parents, 'label'=>Yii::t('news', 'Adding Post') ));
	}
	
	/**
	 * edit post action
	 */
	public function actioneditpost()
	{
		// Check Access
		checkAccessThrowException('op_news_editposts');
		
		if( isset($_GET['id']) && ( $model = News::model()->findByPk( $_GET['id'] ) ) )
		{
			if( isset($_POST['News']) )
			{
				$model->attributes = $_POST['News'];
				if( $model->save() )
				{
					Yii::app()->user->setFlash('success', Yii::t('news', 'Post Updated.'));
					$this->redirect(array('viewcategory', 'id'=>$model->catid));
				}
			}
		
			// cat list
			$parents = array();
			$parentlist = NewsCats::model()->getRootCats();
			if( count( $parentlist ) )
			{
				foreach($parentlist as $row)
				{
					$parents[ $row->id ] = $row->title;
				}
			}
	
			$this->breadcrumbs[ Yii::t('news', 'Editing Post') ] = '';
			$this->pageTitle[] = Yii::t('news', 'Editing Post');
		
			// Render
			$this->render('post_form', array('model'=>$model, 'parents' => $parents, 'label'=>Yii::t('news', 'Editing Post') ));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('news', 'Post was not found.'));
			$this->redirect(array('index'));
		}
	}
	
	/**
	 * Toggle post status
	 */
	public function actiontogglepost()
	{
		// Check Access
		checkAccessThrowException('op_news_manage');
		
		if( isset($_GET['id']) && ( $model = News::model()->findByPk( $_GET['id'] ) ) )
		{
			$update = $model->status ? 0 : 1;
			$model->status = $update;
			$model->save();
			
			Yii::app()->user->setFlash('success', Yii::t('news', 'Post status Updated.'));
			$this->redirect(array('viewcategory', 'id'=>$model->catid));
		}
		else
		{
			Yii::app()->user->setFlash('error', Yii::t('news', 'Post was not found.'));
			$this->redirect(array('index'));
		}
	}
	
	/**
	 * Delete post action
	 */
	public function actiondeletepost()
	{
		// Check Access
		checkAccessThrowException('op_news_deleteposts');
		
		if( isset($_GET['id']) && ( $model = News::model()->findByPk($_GET['id']) ) )
		{			
			$catid = $model->catid;
			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('news', 'Post Deleted.'));
			$this->redirect(array('viewcategory', 'id'=>$catid));
		}
		else
		{
			$this->redirect(array('index'));
		}
	}
	
	/**
	 * Manage comments
	 */
	public function actioncomments()
	{
		// Check Access
		checkAccessThrowException('op_news_comments');
		
		// Did we submit the form and selected items?
		if( checkAccess('op_news_comments_manage') && isset($_POST['bulkoperations']) && $_POST['bulkoperations'] != '' )
		{
			// Did we choose any values?
			if( isset($_POST['comment']) && count($_POST['comment']) )
			{
				// What operation we would like to do?
				switch( $_POST['bulkoperations'] )
				{
					case 'bulkdelete':
					
					// Check Access
					checkAccessThrowException('op_news_deletecomments');
					
					// Load comments and delete them
					$comments_deleted = NewsComments::model()->deleteByPk(array_keys($_POST['comment']));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('news', '{count} comments deleted.', array('{count}'=>$comments_deleted)));
					break;
					
					case 'bulkapprove':
					// Load comments
					$comments = NewsComments::model()->updateByPk(array_keys($_POST['comment']), array('visible'=>1));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('news', '{count} comments approved.', array('{count}'=>$comments)));
					break;
					
					case 'bulkunapprove':
					// Load comments
					$comments = NewsComments::model()->updateByPk(array_keys($_POST['comment']), array('visible'=>0));
					// Done
					Yii::app()->user->setFlash('success', Yii::t('news', '{count} comments Un-Approved.', array('{count}'=>$comments)));
					break;
					
					default:
					// Nothing
					break;
				}
			}
		}
		
		// Grab the language data
		$criteria = new CDbCriteria;
		
		$count = NewsComments::model()->count($criteria);
		$pages = new CPagination($count);
		$pages->pageSize = self::PAGE_SIZE;
		
		$pages->applyLimit($criteria);
		
		$sort = new CSort('NewsComments');
		
		$sort->defaultOrder = 'postdate DESC';
		$sort->applyOrder($criteria);
		$sort->attributes = array(
		        'tid' => 't.id',
				'authorid' => 'authorid',
				'postdate' => 'postdate',
				'visible' => 'visible',
		);
		
		$comments = NewsComments::model()->with(array('author'))->findAll($criteria);
		
		$this->breadcrumbs[ Yii::t('news', 'Manage Comments') ] = array('news/comments');
		$this->pageTitle[] = Yii::t('news', 'Manage Comments');
		
		$this->render('comments', array( 'comments' => $comments, 'sort'=>$sort, 'pages'=>$pages, 'count' => $count ));
	}
	
	/**
	 * Change comment visibility status
	 */
	public function actiontogglecommentstatus()
	{
		// Check Access
		checkAccessThrowException('op_news_comments');
		
		if( isset($_GET['id']) && ( $model = NewsComments::model()->findByPk($_GET['id']) ) )
		{			
			$model->visible = $model->visible == 1 ? 0 : 1;
			$model->save();
			
			Yii::app()->user->setFlash('success', Yii::t('news', 'Comment Updated.'));
			$this->redirect(array('comments'));
		}
		else
		{
			$this->redirect(array('comments'));
		}
	}
	
	/**
	 * Delete comment action
	 */
	public function actiondeletecomment()
	{
		// Check Access
		checkAccessThrowException('op_news_deletecomments');
		
		if( isset($_GET['id']) && ( $model = NewsComments::model()->findByPk($_GET['id']) ) )
		{			
			$model->delete();
			
			Yii::app()->user->setFlash('success', Yii::t('news', 'Comment Deleted.'));
			$this->redirect(array('comments'));
		}
		else
		{
			$this->redirect(array('comments'));
		}
	}
}