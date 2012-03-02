<?php $this->beginClip('page_buttons'); ?>
	<?php echo CHtml::link(Yii::t('news', 'Index'), array('news/index'), array( 'class' => 'button medium' )); ?>
<?php $this->endClip('page_buttons'); ?>

<?php $this->beginClip('sub_nav'); ?>
	<?php echo $this->renderPartial('/subnavs/content', array(), true); ?>
<?php $this->endClip('sub_nav'); ?>

<div class="container_4">

	<div class="grid_4">
		<div class="panel">
			<h2 class="cap"><?php echo Yii::t('news', 'Comments'); ?></h2>
			<div class="content">
				<?php echo CHtml::form(); ?>
				<table id="news-table" class="tablesorter styled">
					<thead>
						<tr>
						   <th style='width: 1%;'><input class="check-all" type="checkbox" /></th>
						   <th style='width: 5%'><?php echo Yii::t('news', 'ID'); ?></th>
						   <th style='width: 20%'><?php echo Yii::t('news', 'Post'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('news', 'Author'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('news', 'Post Date'); ?></th>
						   <th style='width: 10%'><?php echo Yii::t('news', 'Status'); ?></th>
						   <th style='width: 30%'><?php echo Yii::t('news', 'Comment'); ?></th>
						   <th style='width: 15%'><?php echo Yii::t('news', 'Options'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php if ( count($comments) ): ?>
					
						<?php foreach ($comments as $row): ?>
							<tr>
								<td><?php echo CHtml::checkbox( 'comment[' . $row->id.']' ); ?></td>
								<td><?php echo $row->id; ?></td>
								<td><?php echo $row->post->title; ?></td>
								<td><?php echo $row->author ? $row->author->username : Yii::t('global', 'Unknown'); ?></td>
								<td class='tooltip' title='<?php echo Yii::t('news', 'Joined Date'); ?>'><?php echo dateTime($row->postdate); ?></td>
								<td>
									<?php echo CHtml::link( $row->visible ? 'Yes' : 'No', array('togglecommentstatus', 'id' => $row->id), array( 'class' => 'tooltip', 'title' => Yii::t('news', 'Toggle comment status!') ) ); ?>
								</td>
								<td><?php echo CHtml::encode(wordwrap($row->comment, 20, '...')); ?></td>
								<td>
									<!-- Icons -->
									 <a href="<?php echo $this->createUrl('deletecomment', array( 'id' => $row->id )); ?>" title="<?php echo Yii::t('news', 'Delete this comment!'); ?> "class='icon-button delete tooltip deletelink'><?php echo Yii::t('admin', 'Delete'); ?></a>
								</td>
							</tr>
						<?php endforeach ?>
		
					<?php else: ?>	
						<tr>
							<td colspan='7' style='text-align:center;'><?php echo Yii::t('news', 'No Comments Found.'); ?></td>
						</tr>
					<?php endif; ?>
					</tbody>
				</table>
				
				<div id="table-pager" class="pager">
					<?php if ( count($comments) ): ?>
					<div class="table-options">
						<select name="bulkoperations" class='chosen'>
							<option value=""><?php echo Yii::t('global', '-- Choose Action --'); ?></option>
							<option value="bulkdelete"><?php echo Yii::t('global', 'Delete Selected'); ?></option>
							<option value="bulkapprove"><?php echo Yii::t('global', 'Approve Selected'); ?></option>
							<option value="bulkunapprove"><?php echo Yii::t('global', 'Un-Approve Selected'); ?></option>
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

<?php JSFile( themeUrl() . '/js/modules/news.js' ); ?>
