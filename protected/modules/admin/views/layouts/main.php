<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="x-ua-compatible" content="ie=edge" />

<!-- Apple iOS Web App Settings -->
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link rel="apple-touch-icon" href="<?php echo themeUrl(); ?>/images/apple-touch-logo.png"/>
<script type="text/javascript"> 
	(function () {
		var filename = navigator.platform === 'iPad' ?
	   		'splash-screen-768x1004.png' : 'splash-screen-640x920.png';
	  	document.write(
	    	'<link rel="apple-touch-startup-image" ' +
	          'href="<?php echo themeUrl(); ?>/images/' + filename + '" />' );
	})();
</script>
<!-- END Apple iOS Web App Settings -->

<title><?php echo implode(' - ', $this->pageTitle); ?></title>

<!--	Load the master stylesheet
		Note: This is a PHP file that loads like a CSS file. This way, we can include
		a custom color very quickly and easily. -->
<link rel="stylesheet" href="<?php echo themeUrl(); ?>/css/master.css" type="text/css" media="screen" />

<!--	Load the "Chosen" stylesheet. You can remove this if your
		select boxes aren't going to make use of the awesome Chosen script. -->
<link rel="stylesheet" href="<?php echo themeUrl(); ?>/js/chosen/chosen.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo themeUrl(); ?>/css/tipsy.css" type="text/css" media="screen" />

<!--	Load the Fancybox stylesheet. You can remove this if you
		are not going to be lightboxing any images. -->
<link rel="stylesheet" href="<?php echo themeUrl(); ?>/js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

<!--	Load the jQuery Library - We're loading in the header because there are quite a few dependencies that require
		The library while the rest of the page loads. These include Highcharts and the Tablesorter scripts. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<!--	Load the Charting/Graph scripts. You can remove this if you will not be displaying any charts. -->
<script src="<?php echo themeUrl(); ?>/js/flot.js" type="text/javascript"></script>
<script src="<?php echo themeUrl(); ?>/js/graphtable.js" type="text/javascript"></script>

<!--	Load the Tablesorter script. You can remove this if you will not be displaying any sortable tables. -->
<script src="<?php echo themeUrl(); ?>/js/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="<?php echo themeUrl(); ?>/js/jquery.tablesorter.pager.js" type="text/javascript"></script>

<!--	Load the Chosen script. You can remove this if you will not be displaying any custom select boxes. -->
<script src="<?php echo themeUrl(); ?>/js/chosen/chosen.jquery.js" type="text/javascript"></script>

<!--	Load the Fancybox script. You can remove this if you will not be displaying any image lightboxes. -->
<script src="<?php echo themeUrl(); ?>/js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>

<!--	Load the AdminPro custom script. THIS IS REQUIRED, but elements within can be removed if unnecessary. -->
<script src="<?php echo themeUrl(); ?>/js/custom.js"></script>

<!--	Load the AdminPro custom script. THIS IS REQUIRED, but elements within can be removed if unnecessary. -->
<script src="<?php echo themeUrl(); ?>/js/jquery.tipsy.js"></script>

<!--	Set up the responsive design sizes. You probably don't want to mess with these AT ALL. -->
<script type="text/javascript">
	var ADAPT_CONFIG = {
	  	path: '<?php echo themeUrl(); ?>/css/',
	  	dynamic: true,
		callback: function(){},
	 	range: [
	    	'0px    to 420px  /// mobile_portrait.css',
	    	'420px  to 760px  /// mobile_landscape.css',
	    	'760px  to 980px  /// 720.css',
	    	'980px  to 1480px /// 960.css',
	    	'1480px			  /// 1400.css'
	  	]
	};
</script>

<!--	Load the Adapt script. This is what changes and resizes elements as you shrink the browser or
		view the AdminPro template on mobile devices. Try it out! -->
<script src="<?php echo themeUrl(); ?>/js/adapt.min.js"></script>

</head>
<body>
		 		
<div class="container_4 no-space header-wrap">

	<div id="header">
	
		<!-- LOGO -->
		<div id="logo" class="grid_3"><h1><?php echo Yii::app()->name; ?></h1></div>
		
		<!-- EYEBROW NAVIGATION -->
		<div id="eyebrow-navigation" class="grid_1">
			<?php if(checkAccess('op_settings_view')): ?>
				<a href="<?php echo $this->createUrl('settings/index'); ?>" class="settings">Settings</a>
			<?php endif; ?>
			<?php if(Yii::app()->user->id): ?>
				<a href="<?php echo $this->createUrl('logout/index'); ?>" class="signout">Sign Out</a>
			<?php endif; ?>
		</div>
		
		<!-- MAIN NAVIGATION WITH ICON CLASSES -->
		<div id="main-navigation">
			<div class="nav-wrap clearfix">
				<div class="grid_3">
			
					<!-- Regular Navigation
						 Each nav item has a different class, you'll notice. This is what creates the different icons you see.
						 To add a new one, simply create a new PNG and create the class for it in "master.html" -->
						 
					<!-- The class "hide-on-mobile" will hide this navigation on a small mobile device. -->
					<?php
					$this->widget('zii.widgets.CMenu', array(
						'htmlOptions' => array('class' => 'hide-on-mobile'),
						'activeCssClass' => 'active',
					    'items' => array(
							// dashboard
							array( 
								'label' => Yii::t('admin', 'Dashboard'), 
								'url' => array('index/index'), 
								'linkOptions' => array( 'class' => 'dashboard' ),
								'visible' => checkAccess('op_dashboard_tab_view'),
							),
							
							// System
							array( 
								'label' => Yii::t('admin', 'System'), 
								'url' => array('settings/index'),
								'linkOptions' => array( 'class' => 'messages' ),
								'visible' => checkAccess('op_system_tab_view'),
							),
							
							// Management
							array( 
								'label' => Yii::t('admin', 'Management'), 
								'url' => array('users/index'), 
								'linkOptions' => array( 'class' => 'users' ),
								'visible' => checkAccess('op_management_tab_view'),
							),
							
							// Content
							array( 
								'label' => Yii::t('admin', 'Content'), 
								'url' => array('custompages/index'), 
								'linkOptions' => array( 'class' => 'gallery' ),
								'visible' => checkAccess('op_content_tab_view'),
							),
					)));
					?>
					
					<!-- The class "show-on-mobile" will show only this navigation on a small mobile device. It's a
					 	 dropdown select box that loads the page upon select. Dependant on JS within "custom.js" -->
					<div class="show-on-mobile">
						<div class="mobile-nav-wrap">
							<select name="navigation" class="mobile-navigation">
								<option value="">Choose a Page...</option>
								<?php if(checkAccess('op_dashboard_tab_view')): ?>
									<option value="<?php echo $this->createUrl('index/index'); ?>">Dashboard</option>
								<?php endif; ?>
								
								<?php if(checkAccess('op_system_tab_view')): ?>
									<option value="<?php echo $this->createUrl('settings/index'); ?>">System</option>
								<?php endif; ?>
								
								<?php if(checkAccess('op_management_tab_view')): ?>
									<option value="<?php echo $this->createUrl('index/index'); ?>">Management</option>
								<?php endif; ?>
								
								<?php if(checkAccess('op_content_tab_view')): ?>
									<option value="<?php echo $this->createUrl('index/index'); ?>">Content</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>
				<!-- END GRID_3 -->
				
				
				
			</div>
			<!-- END NAV WRAP -->
			
		</div>
		<!-- END MAIN NAVIGATION -->
		
	</div>
	<!-- END HEADER -->
	
</div>
<!-- END CONTAINER_4 - HEADER -->

<?php if($this->clips['sub_nav']): ?>
<!-- BEGIN SUBNAVIGATION -->
<div class="container_4 no-space">
	<div id="subpages" class="clearfix">
		<div class="grid_4">
			<div class="subpage-wrap">
				<?php echo $this->clips['sub_nav']; ?>
			</div>
		</div>
	</div>
</div>
<!-- END SUBNAVIGATION -->
<?php endif; ?>

<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4 no-space">
	<div id="page-heading" class="clearfix">
		<div class="grid_2 title-crumbs">
			<div class="page-wrap">
				<h2><?php echo end($this->pageTitle) ?></h2>
			</div>
		</div>
		<div class="grid_2 align_right">
			<div class="page-wrap">
				<?php echo $this->clips['page_buttons']; ?>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->

<?php if(hasFlash('success')): ?>
<!-- CONFIRM MESSAGE -->
<div class="container_4 no-space push-down">
	<div class="alert-wrapper confirm clearfix">
		<div class="grid_4">
			<div class="alert-text">
				<?php echo getFlash('success'); ?>
				<a href="#" class="close">Close</a>
			</div>
		</div>
	</div>
</div>
<!-- CONFIRM MESSAGE -->
<?php endif; ?>

<?php if(hasFlash('error')): ?>
<!-- ERROR MESSAGE -->
<div class="container_4 no-space push-down">
	<div class="alert-wrapper error clearfix">
		<div class="alert-text">
			<?php echo getFlash('error'); ?>
			<a href="#" class="close">Close</a>
		</div>
	</div>
</div>
<!-- ERROR MESSAGE -->
<?php endif; ?>


<!-- MAIN CONTENT -->
	<?php echo $content; ?>
<!-- MAIN CONTENT -->


<!-- FOOTER -->
<div id="footer" class="container_4">
	<div class="grid_2">Copyright &copy; <?php echo date('Y'); ?> <?php echo Yii::app()->name; ?></div>
</div>
<!-- END FOOTER -->

</body>
</html>