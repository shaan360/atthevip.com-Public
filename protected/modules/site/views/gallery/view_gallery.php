<?php
$cs = Yii::app()->clientScript;
$cs->registerMetaTag($row->name, 'og:title');
if($row->event) {
	$cs->registerMetaTag($row->event->description, 'og:description');
}
$cs->registerMetaTag('bar', 'og:type');
$cs->registerMetaTag($this->createAbsoluteUrl($row->getLink()), 'og:url');
$cs->registerMetaTag($row->coverObject->large->object_link, 'og:image');

if($row->hasClub()) {
	$cs->registerMetaTag($row->club->name, 'og:location');
	$cs->registerMetaTag($row->club->location, 'og:street-address');
} else {
	$cs->registerMetaTag($row->getLocationForDisplay(), 'og:location');
}


?>

<!--Main Section-->
<div class="col1">
 <!-- Left Section -->
	<div class="colheading1">
    	<h1><?php echo $row->name; ?></h1>
    </div>			
    <div class="blogdetail">
    <div class="blgtop">
    <div class="pstinfo">
    	<ul>
			<li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('gallery', 'Location:'); ?></span>
 				<span class="colr4">
				<?php if($row->hasClub()): ?>
           			<?php echo CHtml::link('<u>'.$row->club->name.'</u>', $row->club->getLink(), array('class' => 'white')); ?>
           		<?php else: ?>
           			<u><?php echo $row->getLocationForDisplay(); ?></u>
           		<?php endif; ?>
                </span>
            </li>
        	<li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('gallery', 'Images:'); ?></span>
                <span class="colr4"><u><?php echo numberFormat($row->countVisibleImages); ?></u></span>
            </li>
            <li style="display:none;" class="pstdby">
            	<span class="colr3"><?php echo Yii::t('gallery', 'Views:'); ?></span>
                <span class="colr4"><u><?php echo numberFormat($row->views); ?></u></span>
            </li>
            <li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('clubs', 'Comments:'); ?></span> 
            	<span class="colr4"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($row->getLink()); ?>></fb:comments-count></span>
            </li>
            <?php if($row->presented_by): ?>
            <li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('clubs', 'Presented By:'); ?></span> 
            	<span class="colr4"><?php echo $row->presented_by; ?></span>
            </li>
            <?php endif; ?>
            <?php if($row->taken_by): ?>
            <li class="pstdby">
            	<span class="colr3"><?php echo Yii::t('clubs', 'Taken By:'); ?></span> 
            	<span class="colr4"><?php echo $row->taken_by; ?></span>
            </li>
            <?php endif; ?>
        </ul>
    </div>
     </div>
    <div class="clear"></div>
     <div class="content">     	
     	<?php if($row->countVisibleImages): ?>
     		<?php foreach($row->visibleImages as $image): ?>
     			<img src="<?php echo $image->large->object_link; ?>" alt="" style="display:none;" />
     			<a href="<?php echo $image->large->object_link; ?>" title="<?php echo $image->comment ? $image->comment : ''; ?>" rel="prettyPhoto[galleryshow]">
     				<img src="<?php echo $image->small->object_link; ?>" alt="<?php echo $row->name; ?>" />
     			</a>
     		<?php endforeach; ?>
     	<?php endif; ?>
     </div>

	<a class="nocomnts colr4" href="javascript:"><fb:comments-count href=<?php echo $this->createAbsoluteUrl($row->getLink()); ?>></fb:comments-count> Comments</a>
    <span class="padr">&nbsp;</span>
    <div class="fb-like" data-href="<?php echo $this->createAbsoluteUrl($row->getLink()); ?>" data-send="true" data-layout="button_count" data-width="50" data-show-faces="true" data-colorscheme="dark"></div>
    
    
 </div>
<div class="clear"></div>
<div style='margin-top:10px;width:100%;'>
	<fb:comments href="<?php echo $this->createAbsoluteUrl($row->getLink()); ?>" num_posts="50" width="600" colorscheme="dark"></fb:comments>
</div>

<?php CSSFile(themeUrl() . '/css/buttonPro.css'); ?>