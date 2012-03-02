<?php $this->beginClip('right_sidebar'); ?>
	<?php $randomEvents = Event::model()->with(array('club'))->upcoming()->byRand()->isPublic()->limit(10)->findAll(); ?>
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
<?php $this->endClip(); ?>

<!--Main Section-->
<div class="col1">
 <!-- Left Section -->
		<div class="colheading1">
    	<div class="galry_title"><h1><?php echo $title; ?></h1></div>
    	<div class="galry_type">&nbsp;</div>
    </div>			
    <div class="clblisting">
    	<ul>
    		<?php foreach($clubs as $club): ?>
        	<li> 
            	<div class="clbthumb">
	            	<a href="<?php echo $this->createUrl($club->getLink()); ?>">
	            		<?php if($club->hasCoverImage()): ?>
	            			<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($club->getCoverImage()), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $club->name; ?>" />
	            		<?php else: ?>
	            			<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode(getParam('no_image', 'http://c779389.r89.cf2.rackcdn.com/clubs_10_26_2011_65923_large-no-image-gif.gif')), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $club->name; ?>" />
	            		<?php endif; ?>
	            	</a>
            	</div>
                <div class="clbdes">
                	<p class="clbtitle"><a class="colr4" href="<?php echo $this->createUrl($club->getLink()); ?>"><?php echo $club->name; ?></a></p>  
                	<p><?php echo substr(strip_tags($club->description), 0, 250); ?></p>
                	<p><?php echo Yii::t('events', 'Location:'); ?> <?php echo $club->location; ?></p>
                	<p><?php echo Yii::t('events', 'Contact Info:'); ?> <?php echo $club->contact_info; ?></p>
                	<div class="clear"></div>
                 	<div class="clbinfo">
                 		<ul>
                			<li class="datetag">
                            	<span class="colr3"><?php echo Yii::t('events', 'Events:'); ?></span> 
                            	<span class="pink padr"><?php echo $club->eventsCount; ?></span>
                           		<span class="colr3"><?php echo Yii::t('events', 'Comments:'); ?></span> 
                            	<span class="pink padr"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($club->getLink()); ?>></fb:comments-count></span> 
                            </li> 
                     	 	<li class="moreinfo"><a href="<?php echo $this->createUrl($club->getLink()); ?>"><?php echo Yii::t('events', ':: More info'); ?></a></li>
                    	</ul>
                 	</div>
                </div>
          	</li>
          	<?php endforeach; ?>
        </ul>
    </div>
    <div class="pagnatn">
    	<?php $this->widget('CLinkPager', array('cssFile' => false, 'htmlOptions' => array('class' => ''), 'header' => '', 'pages' => $pages)); ?>
      </div>    
<div class="clear"></div>