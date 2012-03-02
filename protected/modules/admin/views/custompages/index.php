<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('custompages', 'Add Custom Page'), array('custompages/addpage'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('custompages', 'Custom Pages'); ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="settings-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'>&nbsp;</th>
						   <th style='width: 20%'><?php echo Yii::t('settings', 'Title'); ?></th>
						   <th style='width: 20%'><?php echo Yii::t('settings', 'Alias'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('settings', 'Posted'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('settings', 'Author'); ?></th>
						   <th style='width: 5%'><?php echo Yii::t('settings', 'Status'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('settings', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<?php if(checkAccess('op_custompages_manage')): ?>
							<td><?php echo CHtml::checkbox( 'record[' . $row->id.']' ); ?></td>
							<?php endif; ?>
							<td><?php echo CHtml::encode($row->title); ?></td>
							<td><?php echo CHtml::encode($row->alias); ?></td>
							<td>
								<?php echo dateTime($row->dateposted); ?>
								<?php if( $row->last_edited_date ): ?>
									<br /><small><span class='tooltip' title='<?php echo Yii::t('custompages', 'Last Modified Date'); ?>'><?php echo dateTime($row->last_edited_date); ?></span></small>
								<?php endif; ?>	
							</td>
							<td>
								<?php echo $row->author ? CHtml::encode($row->author->username) : Yii::t('admin', 'Unknown'); ?>
								<?php if( $row->last_edited_author ): ?>
									<br /><small><span class='tooltip' title='<?php echo Yii::t('custompages', 'Last Modified By'); ?>'><?php echo $row->lastauthor ? CHtml::encode($row->lastauthor->username) : Yii::t('admin', 'Unknown'); ?></span></small>
								<?php endif; ?>
							</td>
							<td>
								<?php echo CHtml::link( $row->status ? 'Active' : 'Hidden', array('custompages/togglestatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('custompages', 'Toggle page status!') ) ); ?>
							</td>
							<td>
								<!-- Icons -->
								 <a href="<?php echo Yii::app()->createAbsoluteUrl('/' . $row->alias); ?>" title="<?php echo Yii::t('custompages', 'view this page'); ?>" target='_blank' class='tooltip icon-button preview'><?php echo Yii::t('custompages', 'Preview'); ?></a>
								 <a href="<?php echo $this->createUrl('custompages/editpage', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('custompages', 'Edit this page'); ?>" class='tooltip icon-button edit'><?php echo Yii::t('custompages', 'Edit'); ?></a>
								 <a href="<?php echo $this->createUrl('custompages/deletepage', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('custompages', 'Delete this page!'); ?> "class='tooltip icon-button delete deletelink'><?php echo Yii::t('custompages', 'Delete'); ?></a>
							</td>
						</tr>
					<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='7' style='text-align:center;'><?php echo Yii::t('settings', 'No Pages Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($rows) && checkAccess('op_custompages_manage') ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<option value="bulkdelete"><?php echo Yii::t('global', 'Delete Selected'); ?></option>
							<option value="bulkapprove"><?php echo Yii::t('global', 'Approve Selected'); ?></option>
							<option value="bulkunapprove"><?php echo Yii::t('global', 'Hide Selected'); ?></option>
						</select>
						<?php echo CHtml::submitButton( Yii::t('global', 'Apply'), array( 'confirm' => Yii::t('admin', 'Are you sure you would like to perform a bulk operation?'), 'class'=>'button blue small')); ?>
					</div>
					
					<?php endif; ?>
					<?php echo CHtml::endForm(); ?>
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

<?php JSFile( themeUrl() . '/js/modules/custompages.js' ); ?>