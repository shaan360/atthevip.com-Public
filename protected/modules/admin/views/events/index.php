<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('events', 'Events'), array('events/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('events', 'Add Event'), array('events/addevent'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('events', 'Events'); ?> - <?php echo count($rows); ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="clubs-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'>
						   		<?php if(checkAccess('op_events_manage')): ?>
						   		<input class="check-all" type="checkbox" />
						   		<?php endif; ?>
						   </th>
						   <th style='width: 1%;'>&nbsp;</th>
						   <th style='width: 20%'><?php echo Yii::t('events', 'Name'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('events', 'Created'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('events', 'Date'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('events', 'Location'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('events', 'Club'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('events', 'Galleries'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('events', 'Public'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('events', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<td>
								<?php if(checkAccess('op_events_manage')): ?>
									<?php echo CHtml::checkbox( 'record[' . $row->id.']' ); ?>
								<?php endif; ?>
							</td>
							<td>
								<?php if($row->cover): ?>
								<?php echo CHtml::image($this->createUrl('gallery/imagethumb', array('image' => $row->large_cover ? urlencode($row->large_cover) : urlencode($row->cover), 'width' => 500, 'height' => 500, 'cropratio' => '1:1')), 'large_cover', array('style' => 'display:none;')); ?>
								<a title="<?php echo $row->title; ?>" rel='events' class="fancybox" href="<?php echo $this->createUrl('gallery/imagethumb', array('image' => $row->large_cover ? urlencode($row->large_cover) : urlencode($row->cover), 'width' => 500, 'height' => 500, 'cropratio' => '1:1')); ?>">
									<img src="<?php echo $this->createUrl('gallery/imagethumb', array('image' => $row->large_cover ? urlencode($row->large_cover) : urlencode($row->cover), 'width' => 50, 'height' => 50, 'cropratio' => '1:1')); ?>" alt="<?php echo $row->title; ?>" />
								</a>
								<?php else: ?>
									&nbsp;
								<?php endif; ?>
							</td>
							<td><?php echo $row->title; ?></td>
							<td><?php echo dateOnly($row->created_date); ?></td>
							<td><?php echo dateOnly($row->date); ?></td>
							<td><?php echo $row->location ? $row->location : '--';; ?></td>
							<td><?php echo $row->club_id && $row->club ? $row->club->name : '--'; ?></td>
							<td><?php echo numberFormat($row->countGalleries); ?></td>
							<td>
								<?php echo CHtml::link( $row->is_public ? 'Yes' : 'No', array('events/togglestatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('events', 'Toggle event status!') ) ); ?>
							</td>
							<td>
								<!-- Icons -->
								<?php if(checkAccess('op_events_edit')): ?>
								 	<a href="<?php echo $this->createUrl('events/editevent', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('events', 'Edit this event'); ?>" class='tooltip icon-button edit'><?php echo Yii::t('events', 'Edit'); ?></a>
								<?php endif; ?>
								<?php if(checkAccess('op_events_delete')): ?>
								 <a href="<?php echo $this->createUrl('events/deleteevent', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('events', 'Delete this event!'); ?> "class='tooltip icon-button delete deletelink'><?php echo Yii::t('events', 'Delete'); ?></a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='10' style='text-align:center;'><?php echo Yii::t('events', 'No Items Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($rows) && checkAccess('op_events_manage') ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<?php if(checkAccess('op_events_bulkdelete')): ?>
								<option value="bulkdelete"><?php echo Yii::t('global', 'Delete Selected'); ?></option>
							<?php endif; ?>
							<option value="bulkapprove"><?php echo Yii::t('global', 'Approve Selected'); ?></option>
							<option value="bulkunapprove"><?php echo Yii::t('global', 'Un-Approve Selected'); ?></option>
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

<?php JSFile( themeUrl() . '/js/modules/events.js' ); ?>