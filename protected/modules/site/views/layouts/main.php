<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="fb:app_id" content="<?php echo getParam('facebook_appid'); ?>"/>
<title><?php echo implode(' - ', $this->pageTitle); ?></title>
<!-- // Css // -->
<link href="<?php echo themeUrl(); ?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo themeUrl(); ?>/css/prettyPhoto.css" rel="stylesheet" type="text/css" />
<!-- // Javascript // -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo themeUrl(); ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo themeUrl(); ?>/js/ddsmoothmenu.js"></script>
<script type="text/javascript" src="<?php echo themeUrl(); ?>/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo themeUrl(); ?>/js/custom.js"></script>
<!--[if lte IE 7]><style>.corners{margin:34px 0px 0px -589px;}</style><![endif]-->
<?php if($this->id == 'contactus'): ?>
<!--[if lt IE 9]>
    	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php endif; ?>
</head>
<body>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo getParam('facebook_appid'); ?>', // App ID
      status     : false, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      oauth      : true, // enable OAuth 2.0
      xfbml      : true  // parse XFBML
    });
  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
</script>
<!-- Header Section -->
<div id="topsec">
	 <div id="masthead">
        	<div class="logo"><a href="<?php echo $this->createUrl('index/index'); ?>"><img src="<?php echo themeUrl(); ?>/images/logo.png"  alt="" /></a></div>
			<div class="header_rightsec">
                <div class="find_us">
                	<ul>
                		<li><a href="https://www.facebook.com/pages/At-The-VIPcom/229437003782897" target="_blank" title="Follow us on facebook!"><img src="<?php echo themeUrl(); ?>/images/social2.png"  alt="" /></a></li>
                        <li>
                        	<fb:like href="http://atthevip.com" send="true" layout="button_count" width="50" show_faces="false" colorscheme="dark" font="arial"></fb:like>
                        </li>
                        <!--<li><a href="#"><img src="<?php echo themeUrl(); ?>/images/social1.png"  alt="" /></a></li>   
                    	<li><a href="#"><img src="<?php echo themeUrl(); ?>/images/social2.png"  alt="" /></a></li>
                    	<li><a href="#"><img src="<?php echo themeUrl(); ?>/images/social3.png"  alt="" /></a></li>
                    	<li><a href="#"><img src="<?php echo themeUrl(); ?>/images/social4.png"  alt="" /></a></li>
                    	<li><a href="#"><img src="<?php echo themeUrl(); ?>/images/social5.png"  alt="" /></a></li>-->
                    </ul>
                </div>
          </div>	        
			<div class="clear" ></div>
		<!-- navigation -->
        <div class="navigation">
        	<div id="smoothmenu1" class="ddsmoothmenu">
				<ul>
                	<li><a href="<?php echo $this->createUrl('/upcoming-events'); ?>"><?php echo Yii::t('site', 'Upcoming Events'); ?></a></li>
 					<li><a href="<?php echo $this->createUrl('/clubs'); ?>"><?php echo Yii::t('site', 'Clubs'); ?></a></li>
 					<li><a href="<?php echo $this->createUrl('/galleries'); ?>"><?php echo Yii::t('site', 'Galleries'); ?></a></li>
 					<li><a href="<?php echo $this->createUrl('/contact-us'); ?>"><?php echo Yii::t('site', 'Contact Us'); ?></a></li>
               </ul>
        	</div>
        </div>
    </div>
</div>
	<!-- Wapper Section -->
    <div id="wrapper_sec">
    <!-- Banner  -->
	
    <!--Content Sec -->
        <div id="content_sec">
			<?php echo $content; ?>
           	<div class="clr"></div>
        </div>
        <?php if(isset($this->clips['right_sidebar']) && $this->clips['right_sidebar']): ?>
        	<!--Right Section-->
            <div class="col2">
            	<?php echo $this->clips['right_sidebar']; ?>
            </div>
        <?php else: ?>
        	<!--Right Section-->
            <div class="col2">
           		<div class="heading2">
               	  <h1><?php echo Yii::t('site', 'UPCOMMING EVENTS'); ?></h1>
                </div>	
              	<!--Event Section -->
                	<ul class="events">
                		<?php $upcomingEvents = Event::model()->with(array('club'))->upcoming()->isPublic()->byDateAsc()->limit()->findAll(); ?>
                		<?php foreach($upcomingEvents as $upcomingEvent): ?>
                		<li>
                			<div class="eventinfo">
                            	<div class="date left">
                                	<span class="colr3" ><?php echo Yii::t('site', 'Date:'); ?></span> 
                                    <span class="colr4"><?php echo $upcomingEvent->getDateForDisplay(); ?></span>
                                </div>	
                           	  <a class="moreinfo bgpos" href="<?php echo $this->createUrl($upcomingEvent->getLink()); ?>"><?php echo Yii::t('site', ':: More Info'); ?></a>
                            </div>
               		  		<div class="eventdetl">
                            	<div class="ethumb">
                            		<a href="<?php echo $this->createUrl($upcomingEvent->getLink()); ?>">
                                		<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => $upcomingEvent->large_cover ? urlencode($upcomingEvent->large_cover) : urlencode($upcomingEvent->cover), 'width' => 110, 'height' => 90, 'cropratio' => '1:1')); ?>" alt="<?php echo $upcomingEvent->title; ?>" />
                                	</a>
                                </div>
									<div class="edesc">
                                		<p><a class="white" href="<?php echo $this->createUrl($upcomingEvent->getLink()); ?>"><?php echo $upcomingEvent->title; ?></a></p>
                                		<p class="white"> 
                                       		<?php if($upcomingEvent->hasClub()): ?>
                                       			<?php echo CHtml::link($upcomingEvent->club->name, $upcomingEvent->club->getLink()); ?>
                                       		<?php else: ?>
                                       			<?php echo $upcomingEvent->getLocationForDisplay(); ?>
                                       		<?php endif; ?>
                                        </p>
                                		<div class="clear"></div>
                                    </div>                            
                       			<div class="clear"></div>
                         	</div> 
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <div class="clear"></div>	
			  	
			  	<?php $randomEvents = Event::model()->with(array('club'))->upcoming()->byRand()->isPublic()->limit(3)->findAll(); ?>
			  	<?php $imageThumb = new ImageThumb(getUploadsPath() . '/index_random_cache/'); ?>
			  	<?php foreach($randomEvents as $randomEvent): ?>
			  		<?php $cover = $randomEvent->large_cover ? $randomEvent->large_cover : $randomEvent->cover; ?>
			  		<?php if($imageThumb->checkImageTooSmall($cover)): ?>
			  			<?php continue; ?>
			  		<?php endif; ?>
			  		<div class="ad">
			  			<a href="<?php echo $this->createUrl($randomEvent->getLink()); ?>" title="<?php echo $randomEvent->title; ?>">
                    		<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($cover), 'width' => 300, 'height' => 280, 'cropratio' => '1:1')); ?>" alt="<?php echo $randomEvent->title; ?>" />
                    	</a>
			  		</div>
			  		<div class="clear"></div>
			  	<?php endforeach; ?>
	        </div>
        <?php endif; ?>
        <div class="clear"></div>
	</div> 
 	<div class="clear"></div>
</div>
<!-- Bottom Section -->
	<div id="bottomsec">
    <!--Footer section -->
  		<div id="footer">
        	<div class="footer_left">
            	<ul class="footerlinks">
                    <li class="nopad"><a href="<?php echo $this->createUrl('index/index'); ?>"><?php echo Yii::t('site', 'Home'); ?></a></li>
                    <li><a href="<?php echo $this->createUrl('/upcoming-events'); ?>"><?php echo Yii::t('site', 'Upcoming Events'); ?></a></li>
 					<li><a href="<?php echo $this->createUrl('/clubs'); ?>"><?php echo Yii::t('site', 'Clubs'); ?></a></li>
 					<li><a href="<?php echo $this->createUrl('/galleries'); ?>"><?php echo Yii::t('site', 'Galleries'); ?></a></li>
 					<li class="last"><a href="<?php echo $this->createUrl('/contact-us'); ?>"><?php echo Yii::t('site', 'Contact Us'); ?></a></li>
                </ul>
       	  		<div class="copyright">
                	<span class="left">&copy; <?php echo date('Y') ?> <strong><?php echo Yii::app()->name; ?></strong> All Rights Reserved</span>  
       				<a  class="top"  href="#"><?php echo Yii::t('site', 'Go to Top'); ?></a>
                </div>
			</div>
        	<div class="suscribe" style='display:none;'>
            	<ul>
                	<li class="stxt" >Get All Events and Club Updates</li>
                    <li class="text"><input value="Enter Email Address Here" 
                    	onfocus="if(this.value=='Enter Email Address Here') {this.value='';}"
                        onblur="if(this.value=='') {this.value='Enter Email Address Here';}"
                    	 name="txt" type="text" />
                    <a href="#" class="btn right" ><span>Submit</span></a>
                    </li>
                </ul>
  			
            </div>
        <div class="clear"></div>
        </div>
</div>
<?php echo getParam('site_footer'); ?>
</body>
</html>
