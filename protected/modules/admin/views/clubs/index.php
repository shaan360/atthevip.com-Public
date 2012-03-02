<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('clubs', 'Clubs'), array('clubs/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('clubs', 'Add Club'), array('clubs/addclub'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('clubs', 'Clubs'); ?></h2>
			<div class="content">
				<table id="clubs-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'>&nbsp;</th>
						   <th style='width: 15%'><?php echo Yii::t('clubs', 'Name'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('clubs', 'Created'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('clubs', 'Events'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('clubs', 'Public'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('clubs', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<td>&nbsp;</td>
							<td><?php echo $row->name; ?></td>
							<td><?php echo dateTime($row->created_date); ?></td>
							<td><?php echo numberFormat($row->eventsCount); ?></td>
							<td>
								<?php echo CHtml::link( $row->is_public ? 'Yes' : 'No', array('clubs/togglestatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('clubs', 'Toggle club status!') ) ); ?>
							</td>
							<td>
								<!-- Icons -->
								<?php if(checkAccess('op_clubs_edit')): ?>
								 <a href="<?php echo $this->createUrl('clubs/editclub', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('clubs', 'Edit this club'); ?>" class='tooltip icon-button edit'><?php echo Yii::t('clubs', 'Edit'); ?></a>
								<?php endif; ?>
								<?php if(checkAccess('op_clubs_delete')): ?>
								 <a href="<?php echo $this->createUrl('clubs/deleteclub', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('clubs', 'Delete this club!'); ?> "class='tooltip icon-button delete deletelink'><?php echo Yii::t('clubs', 'Delete'); ?></a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='5' style='text-align:center;'><?php echo Yii::t('clubs', 'No Items Found.'); ?></td>
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

<?php JSFile( themeUrl() . '/js/modules/clubs.js' ); ?>