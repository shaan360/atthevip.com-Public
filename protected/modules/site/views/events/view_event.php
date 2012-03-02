<?php $this->beginClip('right_sidebar'); ?>
    <div class="heading2">
   	  <h1><?php echo Yii::t('site', 'Flyer'); ?></h1>
    </div>
    <div class='sidebar-right'>
    	<div>
    		<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => $event->large_cover ? urlencode($event->large_cover) : urlencode($event->cover), 'width' => 270, 'height' => 270, 'cropratio' => '1:1')); ?>" alt="<?php echo $event->title; ?>" />
    	</div>
   	</div>
<?php $this->endClip(); ?>

<!--Main Section-->
<div class="col1">
 <!-- Left Section -->
		<div class="colheading1">
    	<h1><?php echo $event->title; ?></h1>
    </div>			
    <div class="blogdetail">
    	<img class="blgimg" src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => $event->large_cover ? urlencode($event->large_cover) : urlencode($event->cover), 'width' => 150, 'height' => 150, 'cropratio' => '1:1')); ?>" alt="<?php echo $event->title; ?>" />
    <div class="blgtop">	
    <div class="blgtitle "><a href='javascript:' class="colr4"><?php echo $event->title; ?></a></div>
    <div class="pstinfo">
    	<ul>
        	<li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('events', 'Location:'); ?></span>
                <?php if($event->hasClub()): ?>
           			<?php echo CHtml::link('<u>'.$event->club->name.'</u>', $this->createAbsoluteUrl($event->club->getLink()), array('class' => 'white')); ?>
           		<?php else: ?>
           			<u><?php echo $event->getLocationForDisplay(); ?></u>
           		<?php endif; ?>
            </li>
            <li class="lstupdte">
            	<span class="colr3"><?php echo Yii::t('events', 'Date:'); ?></span> 
                <span class="colr4"><?php echo $event->getDateForDisplay(); ?></span>
            </li>
            <li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('events', 'Comments:'); ?></span> 
            	<span class="colr4"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($event->getLink()); ?>></fb:comments-count></span>
            </li>
        </ul>
    </div>
     </div>
    <div class='clear'></div>
     <div class="content">
     	<?php echo $event->content; ?>
     </div>

	<a class="nocomnts colr4" href="javascript:"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($event->getLink()); ?>></fb:comments-count> Comments</a>
    <span class="padr">&nbsp;</span>
    <div class="fb-like" data-href="<?php echo $this->createAbsoluteUrl($event->getLink()); ?>" data-send="true" data-layout="button_count" data-width="50" data-show-faces="true" data-colorscheme="dark"></div>
    
    
 </div>
<div class="clear"></div>
<div style='margin-top:10px;width:100%;'>
	<fb:comments href="<?php echo $this->createAbsoluteUrl($event->getLink()); ?>" num_posts="50" width="600" colorscheme="dark"></fb:comments>
</div>