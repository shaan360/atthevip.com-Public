<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('media', 'Media Manager'), array('media/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Add Container'), array('media/addcontainer'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Add Object'), array('media/addobject'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('media', 'Sync Containers'), array('media/synccontainers'), array( 'class' => 'button medium red' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('media', 'Media Containers'); ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="media-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'>&nbsp;</th>
						   <th style='width: 15%'><?php echo Yii::t('media', 'Name'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('media', 'Created'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('media', 'Files (DB)'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('media', 'Files (Cloud)'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('media', 'Size'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('media', 'Public'); ?></th>
						   <th style='width: 20%'><?php echo Yii::t('media', 'URL'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('media', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<?php if(checkAccess('op_media_manage_containers')): ?>
							<td><?php echo CHtml::checkbox( 'record[' . $row->id.']' ); ?></td>
							<?php endif; ?>
							<td><?php echo CHtml::link($row->name, array('media/viewcontainer', 'id' => $row->id)); ?></td>
							<td><?php echo dateTime($row->created_date); ?></td>
							<td><?php echo numberFormat($row->objectCount); ?></td>
							<td><?php echo numberFormat($row->files); ?></td>
							<td><?php echo formatBytes($row->total_size); ?></td>
							<td>
								<?php echo CHtml::link( $row->is_public ? 'Yes' : 'No', array('media/togglecontainerstatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('media', 'Toggle container status!') ) ); ?>
							</td>
							<td><?php echo $row->container_url ? CHtml::link($row->container_url, $row->container_url) : '--'; ?></td>
							<td>
								<!-- Icons -->
								 <a href="<?php echo $this->createUrl('media/synccontainer', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('media', 'sync this container'); ?>" class='tooltip icon-button revert'><?php echo Yii::t('media', 'Sync'); ?></a>
								 <a href="<?php echo $this->createUrl('media/viewcontainer', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('media', 'view this container'); ?>" class='tooltip icon-button preview'><?php echo Yii::t('media', 'View'); ?></a>
								 <a href="<?php echo $this->createUrl('media/editcontainer', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('media', 'Edit this container'); ?>" class='tooltip icon-button edit'><?php echo Yii::t('media', 'Edit'); ?></a>
								 <a href="<?php echo $this->createUrl('media/deletecontainer', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('media', 'Delete this container!'); ?> "class='tooltip icon-button delete deletelink'><?php echo Yii::t('media', 'Delete'); ?></a>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='9' style='text-align:center;'><?php echo Yii::t('media', 'No Items Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($rows) && checkAccess('op_media_manage_containers') ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<option value="bulkapprove"><?php echo Yii::t('global', 'Publish Selected'); ?></option>
							<option value="bulkunapprove"><?php echo Yii::t('global', 'Unpublish Selected'); ?></option>
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