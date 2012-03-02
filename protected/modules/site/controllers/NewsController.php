<?php
/**
 * News controller Home page
 */
class NewsController extends SiteBaseController {
	
	const PAGE_SIZE = 20;
	
	/**
	 * Controller constructor
	 */
    public function init()
    {
        parent::init();

		// Add page breadcrumb and title
		$this->pageTitle[] = Yii::t('news', 'News');
		$this->breadcrumbs[ Yii::t('news', 'News') ] = array('news/index');
    }

	/**
	 * Index action
	 */
    public function actionIndex() {
		
		$posts = News::model()->grabPostsByCats( array_keys(NewsCats::model()->getCatsForMember()), self::PAGE_SIZE);
	
        $this->render('view_category', array( 'posts' => $posts['posts'], 'pages' => $posts['pages'] ));
    }

	/**
	 * Pending posts
	 */
	public function actionshowpending()
	{
		
		// Check Access
		checkAccessThrowException('op_news_manage');
		
		// Grab the language data
		$criteria = new CDbCriteria;
		$criteria->condition = 'status=0';
		$criteria->order = 'postdate DESC';

		$total = News::model()->count($criteria);
		$pages = new CPagination($total);
		$pages->pageSize = self::PAGE_SIZE;

		$pages->applyLimit($criteria);

		// Grab comments
		$rows = News::model()->findAll($criteria);
		
		// Add page breadcrumb and title
		$this->pageTitle[] = Yii::t('news', '{count} Pending Posts', array('{count}'=>$total));
		$this->breadcrumbs[ Yii::t('news', '{count} Pending Posts', array('{count}'=>$total)) ] = '';

        $this->render('view_category', array( 'posts' => $rows, 'pages' => $pages ));
	}
	
	/**
	 * view my Posts
	 */
	public function actionshowmyposts()
	{		
		// Grab the language data
		$criteria = new CDbCriteria;
		$criteria->condition = 'authorid=:userid';
		$criteria->params = array(':userid'=>Yii::app()->user->id);
		$criteria->order = 'postdate DESC';

		$total = News::model()->count($criteria);
		$pages = new CPagination($total);
		$pages->pageSize = self::PAGE_SIZE;

		$pages->applyLimit($criteria);

		// Grab comments
		$rows = News::model()->findAll($criteria);
		
		// Add page breadcrumb and title
		$this->pageTitle[] = Yii::t('news', 'My Posts');
		$this->breadcrumbs[ Yii::t('news', 'My Posts') ] = '';

        $this->render('view_category', array( 'posts' => $rows, 'pages' => $pages ));
	}

	/**
	 * View a single category
	 */
	public function actionviewcategory()
	{
		if( isset($_GET['alias']) && ( $model = NewsCats::model()->find('alias=:alias', array(':alias'=> NewsCats::model()->getAlias( $_GET['alias'] ) )) ) )
		{
			// Can we view it?
			$cats = NewsCats::model()->getCatsForMember();
			
			if( !in_array( $model->id, array_keys( $cats ) ) )
			{
				throw new CHttpException(404, Yii::t('error', 'Sorry, We could not find that category.'));
			}

			$posts = News::model()->grabPostsByCats($model->id , 20);
			
			// Add in the meta keys and description if any
			if( $model->metadesc )
			{
				Yii::app()->clientScript->registerMetaTag( $model->metadesc, 'description' );
			}
			
			if( $model->metakeys )
			{
				Yii::app()->clientScript->registerMetaTag( $model->metakeys, 'keywords' );
			}
			
			//$model->alias = NewsCats::model()->getAlias( $model->alias );
			
			// Add page breadcrumb and title
			$this->pageTitle[] = $model->title;
			$this->breadcrumbs[ $model->title ] = '';

	        $this->render('view_category', array( 'model' => $model, 'posts' => $posts['posts'], 'pages' => $posts['pages'] ));
		}
		else
		{
			throw new CHttpException(404, Yii::t('error', 'Sorry, We could not find that category.'));
		}
	}
	
	/**
	 * View post
	 */
	public function actionviewpost()
	{
		if( isset($_GET['alias']) && ( $model = News::model()->with(array('category', 'author', 'comments', 'commentscount'))->find('t.alias=:alias', array(':alias'=> News::model()->getAlias( $_GET['alias'] ) )) ) )
		{
			// Can we view it?
			$cats = NewsCats::model()->getCatsForMember();

			if( !in_array( $model->catid, array_keys( $cats ) ) )
			{
				throw new CHttpException(404, Yii::t('error', 'Sorry, We could not find that post.'));
			}
			
			// Is it hidden?
			if( !$model->status )
			{				
				// Check Access
				checkAccessThrowException('op_news_manage');
			}
			
			// Update views
			$model->views++;
			$model->update();
			
			$content = $model->content;

			$category = NewsCats::model()->findByPk($model->catid);

			// Add in the meta keys and description if any
			if( $model->metadesc )
			{
				Yii::app()->clientScript->registerMetaTag( $model->metadesc, 'description' );
			}

			if( $model->metakeys )
			{
				Yii::app()->clientScript->registerMetaTag( $model->metakeys, 'keywords' );
			}
			
			$commentsModel = new NewsComments;
			
			// Can add comments?
			$addcomments = false;
			$autoaddcomments = false;
			if( $category->addcommentsperms )
			{
				$perms = explode(',', $category->addcommentsperms);
				
				foreach($perms as $perm)
				{
					if( checkAccess($perm) )
					{
						$addcomments = true;
						break;
					}
				}
			}
			else
			{
				$addcomments = true;
			}
			
			if( $category->autoaddperms )
			{
				$perms = explode(',', $category->autoaddperms);
				
				foreach($perms as $permc)
				{
					if( checkAccess($permc) )
					{
						$autoaddcomments = true;
						break;
					}
				}
			}
			else
			{
				$autoaddcomments = true;
			}	
			
			// Override to add comments to users by default
			if( Yii::app()->user->id )
			{
				$autoaddcomments = true;
			}		

			if( $addcomments )
			{
				if( isset($_POST['NewsComments']) )
				{
					$commentsModel->attributes = $_POST['NewsComments'];
					$commentsModel->postid = $model->id;
					$commentsModel->visible = $autoaddcomments ? 1 : 0;
					if( $commentsModel->save() )
					{
						Yii::app()->user->setFlash('success', Yii::t('news', 'Comment Added.'));
						$commentsModel = new NewsComments;
					}
				}
			}

			// Grab the language data
			$criteria = new CDbCriteria;
			$criteria->condition = 'postid=:postid AND visible=:visible';
			$criteria->params = array( ':postid' => $model->id, ':visible' => 1 );
			$criteria->order = 'postdate DESC';

			// Load only approved
			if( checkAccess('op_news_comments')  )
			{
				$criteria->condition .= ' OR visible=0';
			}

			$totalcomments = NewsComments::model()->count($criteria);
			$pages = new CPagination($totalcomments);
			$pages->pageSize = self::PAGE_SIZE;

			$pages->applyLimit($criteria);

			// Grab comments
			$comments = NewsComments::model()->orderDate()->findAll($criteria);
			
			// Make sure we prepare it for the like button
			Yii::app()->clientScript->registerMetaTag( $model->title, 'og:title' );
			Yii::app()->clientScript->registerMetaTag( 'article', 'og:type' );
			Yii::app()->clientScript->registerMetaTag( Yii::app()->createAbsoluteUrl('/news/'.$model->alias), 'og:url' );
			Yii::app()->clientScript->registerMetaTag( Yii::app()->request->getBaseUrl(true) . Yii::app()->themeManager->baseUrl . '/images/logo.png', 'og:image' );
			Yii::app()->clientScript->registerMetaTag( Yii::app()->name, 'og:site_name' );
			Yii::app()->clientScript->registerMetaTag( $model->description, 'og:description' );

			// Add page breadcrumb and title
			$this->pageTitle[] = $category->title;
			$this->breadcrumbs[ $category->title ] = array('/news/category/' . $category->alias, 'lang'=>false);
			
			$this->pageTitle[] = $model->title;
			$this->breadcrumbs[ $model->title ] = '';
			
			// Load facebook
			Yii::import('ext.facebook.facebookLib');
			$facebook = new facebookLib(array( 'appId' => Yii::app()->params['facebookapikey'], 'secret' => Yii::app()->params['facebookapisecret'], 'cookie' => true, 'disableSSLCheck' => true ));

			$this->render('view_post',array( 'facebook' => $facebook, 'addcomments' => $addcomments, 'content'=>$content, 'model' => $model, 'pages' => $pages, 'commentsModel' => $commentsModel, 'totalcomments' => $totalcomments, 'comments'=>$comments));
		}
		else
		{
			throw new CHttpException(404, Yii::t('error', 'Sorry, We could not find that post.'));
		}
	}
	
	/**
	 * Are we allowed to add posts?
	 */
	public function actionaddpost()
	{		
		// Check Access
		checkAccessThrowException('op_news_addposts');
		
		$model = new News;
		
		if( isset($_POST['News']) )
		{
			$model->attributes = $_POST['News'];
			
			if( !checkAccess('op_news_manage') )
			{
				// Can we auto approve posts for this category?
				$model->status = 0;
				$cat = NewsCats::model()->findByPk($model->catid);
				if( $cat )
				{
					if( $cat->autoaddperms )
					{
						$perms = explode(',', $cat->autoaddperms);
						if( count($perms) )
						{
							foreach($perms as $perm)
							{
								if( checkAccess($perm) )
								{
									$model->status = 1;
									break;
								}
							}
						}
					}
				}
			}
			
			if( $model->save() )
			{
				if( $model->status )
				{
					Yii::app()->user->setFlash('success', Yii::t('news', 'Post Added.'));
					$this->redirect(array('/news/' . $model->alias ));
				}
				else
				{
					Yii::app()->user->setFlash('success', Yii::t('news', 'Post Added. It will be displayed once approved.'));
					$this->redirect('news/index');
				}
			}
		}
		
		// Grab cats that we can add posts to
		$cats = NewsCats::model()->getCatsForMember(null, 'add');

		// Make a category selection
		$categories = array();
		
		foreach($cats as $cat)
		{
			$categories[ $cat->id ] = $cat->title;
		}
		
		// Add page breadcrumb and title
		$this->pageTitle[] = Yii::t('news', 'Adding Post');
		$this->breadcrumbs[ Yii::t('news', 'Adding Post') ] = '';
		
		$this->render('post_form', array( 'model' => $model, 'label' => Yii::t('news', 'Adding Post'), 'categories' => $categories ));
	}
	
	/**
	 * Are we allowed to edit posts?
	 */
	public function actioneditpost()
	{
		// Check Access
		checkAccessThrowException('op_news_editposts');
		
		if( isset($_GET['id']) && ( $model = News::model()->findByPk( $_GET['id'] ) ) )
		{
			// Make sure the author or a manager edits the post
			if( !News::model()->canEditPost( $model ) )
			{
				throw new CHttpException(403, Yii::t('error', 'Sorry, You are not allowed to perform that action.'));
			}
			
			if( isset($_POST['News']) )
			{
				$model->attributes = $_POST['News'];
			
				if( !checkAccess('op_news_manage') )
				{
					// Can we auto approve posts for this category?
					$model->status = 0;
					$cat = NewsCats::model()->findByPk($model->catid);
					if( $cat )
					{
						if( $cat->autoaddperms )
						{
							$perms = explode(',', $cat->autoaddperms);
							if( count($perms) )
							{
								foreach($perms as $perm)
								{
									if( checkAccess($perm) )
									{
										$model->status = 1;
										break;
									}
								}
							}
						}
					}
				}
			
				if( $model->save() )
				{
					if( $model->status )
					{
						Yii::app()->user->setFlash('success', Yii::t('news', 'Post Updated.'));
						$this->redirect(array('/news/' . $model->alias ));
					}
					else
					{
						Yii::app()->user->setFlash('success', Yii::t('news', 'Post Updated. It will be displayed once approved.'));
						$this->redirect('news/index');
					}
				}
			}
		
			// Grab cats that we can add posts to
			$cats = NewsCats::model()->getCatsForMember(null, 'add');

			// Make a category selection
			$categories = array();
		
			foreach($cats as $cat)
			{
				$categories[ $cat->id ] = $cat->title;
			}
		
			// Add page breadcrumb and title
			$this->pageTitle[] = Yii::t('news', 'Editing Post');
			$this->breadcrumbs[ Yii::t('news', 'Editing Post') ] = '';
		
			$this->render('post_form', array( 'model' => $model, 'label' => Yii::t('news', 'Editing Post'), 'categories' => $categories ));
		
		}
		else
		{
			throw new CHttpException(404, Yii::t('error', 'Sorry, We could not find that post.'));
		}
	}
	
	/**
	 * Change comment visibility status
	 */
	public function actiontogglestatus()
	{
		// Check Access
		checkAccessThrowException('op_news_comments');
		
		if( isset($_GET['id']) && ( $model = NewsComments::model()->findByPk($_GET['id']) ) )
		{			
			$model->visible = $model->visible == 1 ? 0 : 1;
			$model->update();
			
			Yii::app()->user->setFlash('success', Yii::t('global', 'Comment Updated.'));
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
		else
		{
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
	}
	
	/**
	 * Approve un-approve post
	 */
	public function actiontogglepost()
	{
		// Check Access
		checkAccessThrowException('op_news_manage');
		
		if( isset($_GET['id']) && ( $model = News::model()->findByPk($_GET['id']) ) )
		{			
			$model->status = $model->status == 1 ? 0 : 1;
			$model->update();
			
			$msg = $model->status ? 'Post Approved' : 'Post UnApproved';
			
			Yii::app()->user->setFlash('success', Yii::t('global', Yii::t('news', $msg)));
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
		else
		{
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
	}
	
	/**
	 * Rate a post action
	 */
	public function actionrating()
	{
		// Accept only post requests
		if( Yii::app()->request->isPostRequest )
		{
			$rating = intval( $_POST['rate'] );
			$id = intval( $_POST['id'] );
			
			$model = News::model()->findByPk($id);
			
			if( $model )
			{
				$model->totalvotes++;
				$model->rating = $model->rating + $rating;
				$model->update();
				
				echo $model->rating;
				Yii::app()->end();
			}
		}
	}
	
	/**
	 * Download post as text
	 */
	public function actiontext()
	{
		if( isset($_GET['id']) && ( $model = News::model()->findByPk($_GET['id']) ) )
		{			
			Yii::app()->func->downloadAs( $model->title, $model->alias, $model->content );
		}
		else
		{
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
	}
	
	/**
	 * Download post as pdf
	 */
	public function actionpdf()
	{
		if( isset($_GET['id']) && ( $model = News::model()->findByPk($_GET['id']) ) )
		{			
			$markdown = new MarkdownParser;
			$model->content = $markdown->safeTransform($model->content);
			$this->layout = false;
			$content = $this->render('index', array('content'=>$model->content), true);
			
			Yii::app()->func->downloadAs( $model->title, $model->alias, $model->content, 'pdf' );
		}
		else
		{
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
	}
	
	/**
	 * Download post as pdf
	 */
	public function actionword()
	{
		if( isset($_GET['id']) && ( $model = News::model()->findByPk($_GET['id']) ) )
		{			
			$markdown = new MarkdownParser;
			$model->content = $markdown->safeTransform($model->content);
			$this->layout = false;
			$content = $this->render('index', array('content'=>$model->content), true);
			
			Yii::app()->func->downloadAs( $model->title, $model->alias, $content, 'word' );
		}
		else
		{
			$this->redirect( Yii::app()->request->getUrlReferrer() );
		}
	}
	
	/**
	 * Posts & Category RSS
	 */
	public function actionrss()
	{
		$criteria = new CDbCriteria;
		
		if( isset($_GET['id']) && ( $model = NewsCats::model()->findByPk($_GET['id']) ) )
		{
			$criteria->condition = 'catid=:catid AND status=:status';
			$criteria->params = array( ':catid' => $model->id, ':status' => 1 );
		}
		else
		{
			$criteria->condition = 'status=:status';
			$criteria->params = array( ':status' => 1 );
		}
		
		$rows = array();
		
		// Load some posts
		$criteria->order = 'postdate DESC';
		$criteria->limit = 50;
		$posts = News::model()->with(array('author'))->findAll($criteria);
		
		$markdown = new MarkdownParser;
		
		if( $posts )
		{
			foreach($posts as $r)
			{
				$r->content = $markdown->safeTransform($r->content);
				
				$rows[] = array(
						'title' => $r->title, 
						'link' => Yii::app()->createAbsoluteUrl('/news/' . $r->alias),
						'charset' => Yii::app()->charset,
						'description' => $r->description,
						'author' => $r->author ? $r->author->username : Yii::app()->name,
					    'generator' => Yii::app()->name,
					    'language'  => Yii::app()->language,
						'guid' => $r->id,
						'content' => $r->content,
					);
			}
		}
		
		$data = array(
						'title' => isset($model) ? $model->title : Yii::t('news', 'News RSS Feed'), 
						'link' => isset($model) ? Yii::app()->createAbsoluteUrl('/news/category/' . $model->alias) : Yii::app()->createAbsoluteUrl('news'),
						'charset' => Yii::app()->charset,
						'description' => isset($model) ? $model->description : Yii::t('news', 'news'),
						'author' => Yii::app()->name,
					    'generator' => Yii::app()->name,
					    'language'  => Yii::app()->language,
					    'ttl'    => 10,
						'entries' => $rows
						);
		Yii::app()->func->displayRss($data);
	}
}