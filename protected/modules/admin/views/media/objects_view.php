<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('media', 'Media Manager'), array('media/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Rackspace Files'), array('media/rackspace'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Add Object'), array('media/addobject', 'container_id' => $container->id), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Add Objects'), array('media/jumploader', 'container_id' => $container->id), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('media', 'Media Objects'); ?> - <?php echo $container->name; ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="media-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'><input class="check-all" type="checkbox" /></th>
						   <th style='width: 1%;'></th>
						   <th style='width: 20%'><?php echo Yii::t('media', 'Name'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('media', 'Created'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('media', 'Size'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('media', 'Ext'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('media', 'Type'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('media', 'Public'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('media', 'URL'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('media', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($container->objects) ): ?>
						
						<?php foreach ($container->objects as $row): ?>
						<tr>
							
							<td><?php if(checkAccess('op_media_manage_objects')): ?><?php echo CHtml::checkbox( 'record[' . $row->id.']' ); ?><?php endif; ?></td>
							<td>
								<?php echo CHtml::image($this->createUrl('gallery/imagethumb', array('image' => urlencode($row->object_link), 'width' => 500, 'height' => 500)), 'large_cover', array('style' => 'display:none;')); ?>
								<a title="<?php echo $row->name; ?>" rel='covers' class="fancybox" href="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($row->object_link), 'width' => 500, 'height' => 500)); ?>">
									<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => urlencode($row->object_link), 'width' => 50, 'height' => 50, 'cropratio' => '1:1')); ?>" alt="<?php echo $row->name; ?>" />
								</a>
							</td>
							<td><?php echo $row->name; ?></td>
							<td><?php echo dateTime($row->created_date); ?></td>
							<td><?php echo formatBytes($row->size); ?></td>
							<td><?php echo $row->ext; ?></td>
							<td><?php echo $row->type; ?></td>
							<td>
								<?php echo CHtml::link( $row->is_active ? 'Yes' : 'No', array('media/toggleobjectstatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('media', 'Toggle object status!') ) ); ?>
							</td>
							<td><?php echo $row->object_link ? CHtml::link('Open Link', $row->object_link, array('target' => '_blank')) : '--'; ?></td>
							<td>
								<!-- Icons -->
								 <a href="<?php echo $this->createUrl('media/editobject', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('media', 'Edit this object'); ?>" class='tooltip icon-button edit'><?php echo Yii::t('media', 'Edit'); ?></a>
								 <a href="<?php echo $this->createUrl('media/deleteobject', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('media', 'Delete this object!'); ?> "class='tooltip icon-button delete deletelink'><?php echo Yii::t('media', 'Delete'); ?></a>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='10' style='text-align:center;'><?php echo Yii::t('media', 'No Items Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($container->objects) && checkAccess('op_media_manage_objects') ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<option value="bulkapprove"><?php echo Yii::t('global', 'Publish Selected'); ?></option>
							<option value="bulkunapprove"><?php echo Yii::t('global', 'Unpublish Selected'); ?></option>
							<option value="bulkdelete"><?php echo Yii::t('global', 'Delete Selected'); ?></option>
						</select>
						<?php echo CHtml::submitButton( Yii::t('global', 'Apply'), array( 'confirm' => Yii::t('admin', 'Are you sure you would like to perform a bulk operation?'), 'class'=>'button blue small')); ?>
					</div>
					
					<?php endif; ?>
					<?php echo CHtml::endForm(); ?>
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

<?php JSFile( themeUrl() . '/js/modules/media.js' ); ?>