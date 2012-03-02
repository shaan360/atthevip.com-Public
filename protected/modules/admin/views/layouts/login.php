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
		
	<link rel="stylesheet" href="<?php echo themeUrl(); ?>/css/login_master.css" type="text/css" media="screen" />
</head>
<body>

<!-- This is the login page, so it has a few custom CSS styles. -->
	
<div id="login-wrapper">
	
	<!-- Start the white form block -->
	<div id="login-form">
		
		<?php if(hasFlash('error')): ?>
		<!-- An error alert example -->
		<div class="alert-wrapper error">
			<div class="alert-text">
				<?php echo getFlash('error'); ?>
				<a href="#" class="close">Close</a>
			</div>
		</div>
		<?php endif; ?>
		
		<?php echo $content; ?>
		
	</div>
	
	<!-- Some footer text, totally optional of course -->
	<div class="under-form">Copyright &copy; <?php echo date('Y'); ?> <?php echo Yii::app()->name; ?></div>

</div>

<!-- Load the jQuery Library and custom.js for the error alerts.
	 You can remove this block if you don't need error alerts on the login form page. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="<?php echo themeUrl(); ?>/js/custom.js"></script>

<!--	Load the AdminPro custom script. THIS IS REQUIRED, but elements within can be removed if unnecessary. -->
<script src="<?php echo themeUrl(); ?>/js/jquery.tipsy.js"></script>

</body>
</html>