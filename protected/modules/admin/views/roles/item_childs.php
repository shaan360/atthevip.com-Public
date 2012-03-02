<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/management', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('roles', 'Roles'), array('roles/index'), array( 'class' => 'button medium' )); ?>
	<?php echo CHtml::link(Yii::t('roles', 'Add Auth Item Child'), array('roles/addauthitemchild', 'parent'=>$_GET['parent']), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('roles', 'Child Auth Items'); ?></h2>
			<div class="content">
				<table id="settings-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 40%'><?php echo Yii::t('roles', 'Parent'); ?></th>
						   <th style='width: 40%'><?php echo Yii::t('roles', 'Child'); ?></th>
						   <th style='width: 20%'><?php echo Yii::t('roles', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($rows) ): ?>
						
						<?php foreach ($rows as $row): ?>
						<tr>
							<td><?php echo CHtml::encode($row->parent); ?></td>
							<td><a href="<?php echo $this->createUrl('roles/viewauthitem', array( 'parent' => $row->child )); ?>" title="<?php echo Yii::t('adminroles', 'View Auth Item'); ?>" class='tooltip'><?php echo CHtml::encode($row->child); ?></a></td>
							<td>
								<!-- Icons -->
								 <a href="<?php echo $this->createUrl('roles/deleteauthitemchild', array( 'parent' => $row->parent, 'child' => $row->child )); ?>" title="<?php echo Yii::t('adminroles', 'Delete this relationship!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('roles', 'Delete'); ?></a>
							</td>
						</tr>
						<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='5' style='text-align:center;'><?php echo Yii::t('roles', 'No roles found.'); ?></td>
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

<?php JSFile( themeUrl() . '/js/modules/roles.js' ); ?>