<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Gallery'), array('gallery/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Add Gallery'), array('gallery/addgallery'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('gallery', 'Clear Caches'), array('gallery/clearcaches'), array( 'class' => 'button medium red' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('gallery', 'Galleries'); ?></h2>
			<div class="content">
				<table id="gallery-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'>&nbsp;</th>
						   <th style='width: 15%'><?php echo Yii::t('gallery', 'Name'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('gallery', 'Created'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('gallery', 'Container'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('gallery', 'Location'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('gallery', 'Event Date'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('gallery', 'Public'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('gallery', 'Images'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('gallery', 'Views'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('gallery', 'Size'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('gallery', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<td>
								<?php if($row->coverObject && $row->coverObject->large): ?>
								<?php echo CHtml::image($this->createUrl('gallery/imagethumb', array('image' => urlencode($row->coverObject->large->object_link), 'width' => 500, 'height' => 500)), 'large_cover', array('style' => 'display:none;')); ?>
								<a title="<?php echo $row->name; ?>" rel='covers' class="fancybox" href="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($row->coverObject->large->object_link), 'width' => 500, 'height' => 500)); ?>">
									<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($row->coverObject->large->object_link), 'width' => 50, 'height' => 50, 'cropratio' => '1:1')); ?>" alt="<?php echo $row->name; ?>" />
								</a>
								<?php else: ?>
									&nbsp;
								<?php endif; ?>
							</td>
						
							<td><?php echo CHtml::link($row->name, array('gallery/viewgallery', 'id' => $row->id)); ?></td>
							<td><?php echo dateOnly($row->created_date); ?></td>
							<td><?php echo $row->container ? CHtml::link($row->container->name, array('media/viewcontainer', 'id' => $row->container_id)) : '--'; ?></td>
							<td><?php echo $row->club ? $row->club->name : $row->location; ?></td>
							<td><?php echo $row->event_date ? dateOnly($row->event_date) : '--'; ?></td>
							<td>
								<?php echo CHtml::link( $row->is_public ? 'Yes' : 'No', array('gallery/togglestatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('gallery', 'Toggle gallery status!') ) ); ?>
							</td>
							<td><?php echo numberFormat($row->countImages); ?></td>
							<td><?php echo numberFormat($row->views); ?></td>
							<td><?php echo formatBytes($row->sumImagesSize()); ?></td>
							<td>
								<!-- Icons -->
								 <a href="<?php echo $this->createUrl('gallery/viewgallery', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('gallery', 'View Images'); ?>" class='tooltip icon-button view'><?php echo Yii::t('gallery', 'View'); ?></a>
								 <a href="<?php echo $this->createUrl('gallery/addimages', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('gallery', 'Add images to this gallery'); ?>" class='tooltip icon-button add'><?php echo Yii::t('gallery', 'Add'); ?></a>
								 <a href="<?php echo $this->createUrl('gallery/editgallery', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('gallery', 'Edit this gallery'); ?>" class='tooltip icon-button edit'><?php echo Yii::t('gallery', 'Edit'); ?></a>
								 <a href="<?php echo $this->createUrl('gallery/deletegallery', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('gallery', 'Delete this gallery!'); ?> "class='tooltip icon-button delete deletelink'><?php echo Yii::t('gallery', 'Delete'); ?></a>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='10' style='text-align:center;'><?php echo Yii::t('gallery', 'No Items Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<form>
						<select class="pagesize">
							<option selected="selected" value="100">100</option>
							<option value="200">200</option>
							<option value="300">300</option>
							<option value="400">400</option>
						</select>
						<a class="button small green first"><img src="<?php echo themeUrl(); ?>/images/table_pager_first.png" alt="First" /></a>
						<a class="button small green prev"><img src="<?php echo themeUrl(); ?>/images/table_pager_previous.png" alt="Previous" /></a>
						<input type="text" class="pagedisplay" disabled="disabled" />
						<a class="button small green next"><img src="<?php echo themeUrl(); ?>/images/table_pager_next.png" alt="Next" /></a>
						<a class="button small green last"><img src="<?php echo themeUrl(); ?>/images/table_pager_last.png" alt="Last" /></a>
					</form>
				</div>
				
			</div>
		</div>
	</div>
	
</div>

<?php JSFile( themeUrl() . '/js/modules/gallery.js' ); ?>