<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/management', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('users', 'Add User'), array('users/adduser'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('users', 'Users'); ?> (<?php echo Yii::app()->format->number($count); ?>)</h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="users-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'><input class="check-all" type="checkbox" /></th>
						   <th style='width: 2%;'>&nbsp;</th>
						   <th style='width: 20%'><?php echo Yii::t('users', 'Username'); ?></th>
						   <th style='width: 20%'><?php echo Yii::t('users', 'Email'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('users', 'Role'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('users', 'Joined'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('users', 'FB ID'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('users', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($members) ): ?>
						
						<?php foreach ($members as $row): ?>
							<tr>
								<td><?php echo CHtml::checkbox( 'user[' . $row->id.']' ); ?></td>
								<td>&nbsp;</td>
								<td><a href="<?php echo $this->createUrl('users/viewuser', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('users', 'View User'); ?>" class='tooltip'><?php echo CHtml::encode($row->username); ?></a></td>
								<td><?php echo CHtml::encode($row->email); ?></td>
								<td><?php echo CHtml::encode($row->role); ?></td>
								<td class='tooltip' title='<?php echo Yii::t('users', 'Joined Date'); ?>'><?php echo dateTime($row->joined); ?></td>
								<td><?php echo $row->fb_uid; ?></td>
								<td>
									<!-- Icons -->
									 <a href="<?php echo $this->createUrl('users/edituser', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('users', 'Edit this member'); ?>" class='icon-button edit tooltip'><?php echo Yii::t('users', 'Edit'); ?></a>
									 <a href="<?php echo $this->createUrl('users/deleteuser', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('users', 'Delete this member!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('users', 'Delete'); ?></a>
								</td>
							</tr>
						<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='8' style='text-align:center;'><?php echo Yii::t('users', 'No Users Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($members) ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<option value="bulkdelete"><?php echo Yii::t('global', 'Delete Selected'); ?></option>
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
							<option value="50">50</option>
							<option value="60">60</option>
							<option value="70">70</option>
							<option value="80">80</option>
							<option value="90">90</option>
							<option value="100">100</option>
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

<?php JSFile( themeUrl() . '/js/modules/users.js' ); ?>