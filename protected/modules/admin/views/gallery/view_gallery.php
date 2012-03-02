<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Gallery'), array('gallery/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Add Images'), array('gallery/addimages', 'id' => $row->id), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">
	 	 
	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('gallery', "Viewing Gallery '{name}'", array('{name}' => $row->name)); ?></h2>
			
			<!-- Be sure you're keeping to this exact structure! -->
			<div class="content gallery">
				<div class="gallery-wrap">
					<div class="gallery-pager">
						<?php echo CHtml::beginForm(); ?>
						<?php $count = 1; ?>
						<?php foreach($row->images as $image): ?>
							<!-- START GALLERY ITEM -->
							<div class="gallery-item <?php echo $image->is_public ? 'visible-image' : 'hidden-image'; ?> <?php echo $image->id == $row->cover ? 'cover-image' : ''; ?>">
								
								<!-- Here's the image with a link to the large version for lightboxing -->
								<a title="<?php echo $image->comment ? $image->comment : "Gallery Image " . $count; ?>" rel="<?php echo 'gallery_group_' . $row->id; ?>" class="fancybox" href="<?php echo $image->large->object_link; ?>">
									<img src="<?php echo $image->medium->object_link; ?>" alt="Gallery Image <?php echo $count; ?>" />
								</a>
								
								<!-- A hidden checked layer for when you check the checkbox over the image. -->
								<div class="checked-layer"></div>
								
								<!-- Edit and Delete options on each image - These become small icons on the bottom right. -->
								<div class="item-options">
									<a class="icon-button edit" href="<?php echo $this->createUrl('gallery/markcover', array('id' => $image->id)); ?>" title="<?php echo Yii::t('gallery', 'Mark As Cover'); ?>">
										<?php echo Yii::t('gallery', 'Mark As Cover'); ?>
									</a>
									<a class="icon-button revert" href="<?php echo $this->createUrl('gallery/toggleimagestatus', array('id' => $image->id)); ?>" title="<?php echo Yii::t('gallery', 'Toggle Visibility'); ?>">
										<?php echo Yii::t('gallery', 'Toggle'); ?>
									</a>
									<a class="icon-button edit" href="<?php echo $this->createUrl('gallery/editcomment', array('id' => $image->id)); ?>" title="<?php echo Yii::t('gallery', 'Edit Comment'); ?>">
										<?php echo Yii::t('gallery', 'Comment'); ?>
									</a>
								</div>
								
								<!-- The checkbox to select an individual image. -->
								<?php if(checkAccess('op_gallery_manage')): ?>
								<div class="checkbox-block">
									<input type="checkbox" name="record[<?php echo $image->id; ?>]" value="" />
									<input type='text' name="order[<?php echo $image->id; ?>]" value="<?php echo $image->order; ?>" size='1' />
								</div>
								<?php endif; ?>
							</div>
							<!-- END GALLERY ITEM -->
							<?php $count++; ?>
						<?php endforeach; ?>
						
					</div>
				</div>
			
				<!-- The gallery pagination/options area. -->
				<div class="pager">
					<?php if(count($row->images) && checkAccess('op_gallery_manage')): ?>
					<!-- Gallery options - these should probably become active once you've checked an image or more. -->
					<div class="gallery-options">
						<?php echo CHtml::submitButton( Yii::t('global', 'Re Order'), array( 'name' => 'reorder', 'confirm' => Yii::t('admin', 'Are you sure you would like to perform a bulk operation?'), 'class'=>'button small')); ?>
						<?php echo CHtml::submitButton( Yii::t('global', 'Mark Hidden'), array( 'name' => 'markhidden', 'confirm' => Yii::t('admin', 'Are you sure you would like to perform a bulk operation?'), 'class'=>'button red small')); ?>
						<?php echo CHtml::submitButton( Yii::t('global', 'Mark Active'), array( 'name' => 'markactive', 'confirm' => Yii::t('admin', 'Are you sure you would like to perform a bulk operation?'), 'class'=>'button blue small')); ?>
					</div>
					
					<?php endif; ?>
					<?php echo CHtml::endForm(); ?>
					<!-- Gallery pagination -->					
					<form>
						<a class="button small green first"><img src="<?php echo themeUrl(); ?>/images/table_pager_first.png" alt="First" /></a>
						<a class="button small green prev"><img src="<?php echo themeUrl(); ?>/images/table_pager_previous.png" alt="Previous" /></a>
						<input type="text" class="pagedisplay" disabled="disabled" />
						<a class="button small green next"><img src="<?php echo themeUrl(); ?>/images/table_pager_next.png" alt="Next" /></a>
						<a class="button small green last"><img src="<?php echo themeUrl(); ?>/images/table_pager_last.png" alt="Last" /></a>
					</form>
				</div>
			
			</div>
			<!-- END CONTENT -->
			
		</div>
		<!-- END PANEL -->
		
	</div>
	<!-- END GRID_4/GALLERY -->
	
</div>

<?php JSFile( themeUrl() . '/js/modules/gallery.js' ); ?>