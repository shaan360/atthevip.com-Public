<?php $this->beginClip('right_sidebar'); ?>
	<div class="heading2">
   	  <h1><?php echo Yii::t('site', 'Info'); ?></h1>
    </div>	
    <div class='align-sidebar'>
    	<div>
    		<span class="colr3"><?php echo Yii::t('clubs', 'Contact Info:'); ?></span>
            <span class="colr4"><?php echo $club->contact_info; ?></span>
    	</div>
    	<div>
    		<span class="colr3"><?php echo Yii::t('clubs', 'Location:'); ?></span>
            <span class="colr4"><?php echo $club->location; ?></span>
    	</div>
    	<div>
    		<span class="colr3"><?php echo Yii::t('clubs', 'Website:'); ?></span>
            <span class="colr4"><?php echo $club->website ? CHtml::link($club->website, $club->website) : '--'; ?></span>
    	</div>
    	<div>
    		<span class="colr3"><?php echo Yii::t('clubs', 'Facebook:'); ?></span>
            <span class="colr4"><?php echo $club->facebook ? CHtml::link($club->facebook, $club->facebook) : '--'; ?></span>
    	</div>
    	<div>
    		<span class="colr3"><?php echo Yii::t('clubs', 'Twitter:'); ?></span>
            <span class="colr4"><?php echo $club->twitter ? CHtml::link($club->twitter, $club->twitter) : '--'; ?></span>
    	</div>
    </div>
    <div class="clear"></div>
    
    <?php if($club->facebook): ?>
    <div class="heading2">
   	  <h1><?php echo Yii::t('site', 'Facebook Page'); ?></h1>
    </div>
    <div class='sidebar-right'>
    	<div>
    		<fb:like-box href="<?php echo $club->facebook; ?>" width="260" colorscheme="dark" show_faces="true" stream="false" header="false"></fb:like-box>
    	</div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
    
    <div class="heading2">
   	  <h1><?php echo Yii::t('site', 'UPCOMMING EVENTS'); ?></h1>
    </div>	
  	<!--Event Section -->
    	<ul class="events">
    		<?php $upcomingEvents = Event::model()->with(array('club'))->upcoming()->isPublic()->byDateAsc()->limit(10)->findAll('club_id=:clubid', array(':clubid' => $club->id)); ?>
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
                            	<span class="pink"><?php echo Yii::t('site', 'Location:'); ?></span> 
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
<?php $this->endClip(); ?>

<!--Main Section-->
<div class="col1">
 <!-- Left Section -->
	<div class="colheading1">
    	<h1><?php echo $club->name; ?></h1>
    </div>			
    <div class="blogdetail">
    	<?php if($club->hasCoverImage()): ?>
			<img class="blgimg" src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($club->getCoverImage()), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $club->name; ?>" />
		<?php else: ?>
			<img class="blgimg" src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode(getParam('no_image', 'http://c779389.r89.cf2.rackcdn.com/clubs_10_26_2011_65923_large-no-image-gif.gif')), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $club->name; ?>" />
		<?php endif; ?>
    <div class="blgtop">	
    <div class="blgtitle "><a href='javascript:' class="colr4"><?php echo $club->name; ?></a></div>
    <div class="pstinfo">
    	<ul>
        	<li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('clubs', 'Events:'); ?></span>
                <span class="colr4"><u><?php echo $club->eventsCount; ?></u></span>
            </li>
            <li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('clubs', 'Comments:'); ?></span> 
            	<span class="colr4"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($club->getLink()); ?>></fb:comments-count></span>
            </li>
        </ul>
    </div>
     </div>
    <div class='clear'></div>
     <div class="content">
     	<?php echo $club->description; ?>
     	<div class='clear'></div>
     	<br />
     	<?php if($club->video): ?>
     	<div class="colheading1">
	    	<h1><?php echo Yii::t('clubs', 'Video'); ?></h1>
	    </div>	
     	<p>
     		<?php echo $club->video; ?>
     	</p>
     	<?php endif; ?>
     	
     	<?php if($club->images): ?>
     	<?php $images = explode("\n", $club->images); ?>
     	<div class="colheading1">
	    	<h1><?php echo Yii::t('clubs', 'Images'); ?></h1>
	    </div>	
     	<p>
     		<?php foreach($images as $image): ?>
     			<img style="display:none;" src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($image), 'width' => 500, 'height' => 500, 'cropratio' => '1:1')); ?>" alt="<?php echo $club->name; ?>" />
     			<a rel="prettyPhoto[clubimages]" href="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($image), 'width' => 500, 'height' => 500, 'cropratio' => '1:1')); ?>" title="<?php echo $club->name; ?>">
     				<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($image), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $club->name; ?>" />
     			</a>
     		<?php endforeach; ?>
     	</p>
     	<?php endif; ?>
     	
     </div>

	
	<a class="nocomnts colr4" href="javascript:">
		<fb:comments-count href=<?php echo $this->createAbsoluteUrl($club->getLink()); ?>></fb:comments-count> Comments
	</a>
    <span class="padr">&nbsp;</span>
    <div class="fb-like" data-href="<?php echo $this->createAbsoluteUrl($club->getLink()); ?>" data-send="true" data-layout="button_count" data-width="50" data-show-faces="true" data-colorscheme="dark"></div>
    
 </div>
<div class="clear"></div>
<div style='margin-top:10px;width:100%;'>
	<fb:comments href="<?php echo $this->createAbsoluteUrl($club->getLink()); ?>" num_posts="50" width="600" colorscheme="dark"></fb:comments>
</div>