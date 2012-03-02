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
    	<h1><?php echo Yii::t('site', 'Latest Galleries'); ?></h1>
    </div>			
    <div class="clblisting">
    	<ul>
    	<?php $latestGalleries = Gallery::model()->with(array('club', 'event', 'countVisibleImages', 'coverObject'))->isPublic()->byDateDesc()->limit(10)->findAll(); ?>
    	<?php foreach($latestGalleries as $row): ?>
        	<li> 
            	<div class="clbthumb">
	        	<?php if($row->coverObject && $row->coverObject->large): ?>
					<a title="<?php echo $row->name; ?>" href="<?php echo $this->createUrl($row->getLink()); ?>">
						<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($row->coverObject->large->object_link), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $row->name; ?>" />
					</a>
				<?php else: ?>
					<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode(getParam('no_image', 'http://c779389.r89.cf2.rackcdn.com/clubs_10_26_2011_65923_large-no-image-gif.gif')), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $row->name; ?>" />
				<?php endif; ?>
            	</div>
                <div class="clbdes">
                	<p class="clbtitle"><a class="colr4" href="<?php echo $this->createUrl($row->getLink()); ?>"><?php echo $row->name; ?></a></p>  
                	<?php if($row->event_id && $row->event): ?>
                		<p><?php echo $row->event->description; ?></p>
                	<?php endif; ?>
                	<div class="clear"></div>
                 	<div class="clbinfo">
                 		<ul>
                			<li class="datetag">
                        		<span class="colr3"><?php echo Yii::t('events', 'Date:'); ?></span> 
                            	<span class="pink padr-small"><?php echo $row->getDateForDisplay(); ?></span>
                            	<span class="colr3"><?php echo Yii::t('events', 'Location:'); ?></span> 
                            	<span class="pink padr-small">
                            	<?php if($row->hasClub()): ?>
                           			<?php echo CHtml::link('<u>'.$row->club->name.'</u>', $row->club->getLink(), array('class' => 'white')); ?>
                           		<?php else: ?>
                           			<u><?php echo $row->getLocationForDisplay(); ?></u>
                           		<?php endif; ?>
                           		</span>
                           		<span class="colr3"><?php echo Yii::t('events', 'Images:'); ?></span> 
                            	<span class="pink padr-small"><?php echo numberFormat($row->countVisibleImages); ?></span>
                            	<span style="display:none;" class="colr3"><?php echo Yii::t('events', 'Views:'); ?></span> 
                            	<span style="display:none;" class="pink padr-small"><?php echo numberFormat($row->views); ?></span>
                           		<span class="colr3"><?php echo Yii::t('events', 'Comments:'); ?></span> 
                            	<span class="pink padr-small"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($row->getLink()); ?>></fb:comments-count></span> 
                            </li>
                    	</ul>
                 	</div>
                </div>
          	</li> 
        <?php endforeach; ?>   	    
        </ul>
    </div>
<div class="clear"></div>  

 <!-- Left Section -->
	<div class="colheading1">
    	<h1><?php echo Yii::t('site', 'Latest Events'); ?></h1>
    </div>			
 	<div class="clblisting">
    	<ul>
    		<?php $events = Event::model()->with(array('club'))->upcoming()->isPublic()->byCreatedDate()->limit(10)->findAll(); ?>
    		<?php foreach($events as $event): ?>
        	<li> 
            	<div class="clbthumb">
	            	<a href="<?php echo $this->createUrl($event->getLink()); ?>">
	            		<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => $event->large_cover ? urlencode($event->large_cover) : urlencode($event->cover), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $event->title; ?>" />
	            	</a>
            	</div>
                <div class="clbdes">
                	<p class="clbtitle"><a class="colr4" href="<?php echo $this->createUrl($event->getLink()); ?>"><?php echo $event->title; ?></a></p>  
                	<p><?php echo $event->description; ?></p>
                	<div class="clear"></div>
                 	<div class="clbinfo">
                 		<ul>
                			<li class="datetag">
                        		<span class="colr3"><?php echo Yii::t('events', 'Date:'); ?></span> 
                            	<span class="pink padr-small"><?php echo $event->getDateForDisplay(); ?></span>
                            	<span class="colr3"><?php echo Yii::t('events', 'Location:'); ?></span> 
                            	<span class="padr-small">
                            	<?php if($event->hasClub()): ?>
                           			<?php echo CHtml::link('<u>'.$event->club->name.'</u>', $event->club->getLink(), array('class' => 'white')); ?>
                           		<?php else: ?>
                           			<u><?php echo $event->getLocationForDisplay(); ?></u>
                           		<?php endif; ?>
                           		</span>
                           		<span class="colr3"><?php echo Yii::t('events', 'Comments:'); ?></span> 
                            	<span class="pink padr-small"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($event->getLink()); ?>></fb:comments-count></span> 
                            </li> 
                     	 </ul>
                 	</div>
                </div>
          	</li>
          	<?php endforeach; ?>
        </ul>
    </div>
<div class="clear"></div>  
		