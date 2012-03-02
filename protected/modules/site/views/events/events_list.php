<!--Main Section-->
<div class="col1">
 <!-- Left Section -->
		<div class="colheading1">
    	<div class="galry_title"><h1><?php echo $title; ?></h1></div>
    	<div class="galry_type"><?php echo CHtml::link(Yii::t('events', 'View All Events'), array('events/index')); ?></div>
    </div>			
    <div class="clblisting">
    	<ul>
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
                            	<span class="pink padr"><?php echo $event->getDateForDisplay(); ?></span>
                            	<span class="colr3"><?php echo Yii::t('events', 'Location:'); ?></span> 
                            	<span class="padr">
                            	<?php if($event->hasClub()): ?>
                           			<?php echo CHtml::link('<u>'.$event->club->name.'</u>', $event->club->getLink(), array('class' => 'white')); ?>
                           		<?php else: ?>
                           			<u><?php echo $event->getLocationForDisplay(); ?></u>
                           		<?php endif; ?>
                           		</span>
                           		<span class="colr3"><?php echo Yii::t('events', 'Comments:'); ?></span> 
                            	<span class="pink padr"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($event->getLink()); ?>></fb:comments-count></span> 
                            </li> 
                     	 	<li class="moreinfo"><a href="<?php echo $this->createUrl($event->getLink()); ?>"><?php echo Yii::t('events', ':: More info'); ?></a></li>
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
		