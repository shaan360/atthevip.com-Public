<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('settings', 'Add Setting Group'), array('settings/addgroup'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('settings', 'Add Setting'), array('settings/addsetting'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/system', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('settings', 'Settings Groups'); ?></h2>
			<div class="content">
				<table id="settings-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 20%'><?php echo Yii::t('settings', 'Title'); ?></th>
						   <th style='width: 50%'><?php echo Yii::t('settings', 'Description'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('settings', 'Key'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('settings', 'Count'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('settings', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($settings) ): ?>
						
						<?php foreach ($settings as $row): ?>
							<tr>
								<td><a href="<?php echo $this->createUrl('settings/viewgroup', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('settings', 'View category settings'); ?>" class='tooltip'><?php echo CHtml::encode($row->title); ?></a></td>
								<td><?php echo CHtml::encode($row->description); ?></td>
								<td><?php echo CHtml::encode($row->groupkey); ?></td>
								<td class='tooltip' title='<?php echo Yii::t('settings', 'Total Settings'); ?>'><?php echo $row->count; ?></td>
								<td>
									<!-- Icons -->
									<a href="<?php echo $this->createUrl('settings/addsetting', array( 'cid' => $row->id )); ?>" title="<?php echo Yii::t('admin', 'Add setting to this group'); ?>" class="icon-button add"><?php echo Yii::t('settings', 'Add'); ?></a>
									 <a href="<?php echo $this->createUrl('settings/editgroup', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('admin', 'Edit this group'); ?>" class="icon-button edit"><?php echo Yii::t('settings', 'Edit'); ?></a>
									 <a href="<?php echo $this->createUrl('settings/deletegroup', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('admin', 'Delete this group!'); ?>" class="icon-button delete deleteLink"><?php echo Yii::t('settings', 'Delete'); ?></a>
								</td>
							</tr>
						<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='5' style='text-align:center;'><?php echo Yii::t('settings', 'No groups found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<form>
						<select class="pagesize">
							<option selected="selected" value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
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

<?php JSFile( themeUrl() . '/js/modules/settings.js' ); ?>